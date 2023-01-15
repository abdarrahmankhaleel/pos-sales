<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Account;
use App\Models\Customer;
use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\Admin_panel_setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomersRequest;
use App\Http\Requests\CustomersRequestEdit;
use App\Http\Requests\AccountsRequestUpdate;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class CustomersController extends Controller
{
    public function index(){
        $com_code=auth()->user()->com_code;
        $data=get_cols_where_p(new Customer(),array("*"),array('com_code'=>$com_code,'active'=>1),'id','ASC',PADINATION_COUNT);
        if(!empty($data)){
        foreach($data as $info){
        $info->created_by_admin = Admin::where('id', $info->created_by)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
        }
    }
    }
    return view('admin.customers.index',['data'=>$data]);

}

public function create()
{
    return view('admin.customers.create');
}


public function store(CustomersRequest $request){
  
    try{
        $com_code=auth()->user()->com_code;
        //check if not exsits for name
        $checkExistsForName=get_cols_row_where(new Customer(),array("id"),array('name'=>trim($request->name),'com_code'=>$com_code));

        if(!empty($checkExistsForName)){
            return redirect()->back()
        ->with(['error'=>'اسم العميل مسجل من قبل'])
        ->withInput(); 
        }
        //end check if not exsits for name
//set customer_code
$row = get_cols_where_row_orderby(new Customer(), array("customer_code"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['customer_code'] = $row['customer_code'] + 1;
} else {
$data_insert['customer_code'] = 1;
}


//set account number
$row = get_cols_where_row_orderby(new Account(), array("account_number"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['account_number'] = $row['account_number'] + 1;
} else {
$data_insert['account_number'] = 1;
}


        $data_insert['name']=$request->name;    
        $data_insert['start_balance_status']=$request->start_balance_status;  
        if( $data_insert['start_balance_status']==1){
            if($request->start_balance>0){
                $data_insert['start_balance']=$request->start_balance*-1;    
            }
        }  elseif($data_insert['start_balance_status']==2){
            if($request->start_balance<0){
                $data_insert['start_balance']=$request->start_balance*-1;    
            }
        }elseif($data_insert['start_balance_status']==3){
            $data_insert['start_balance']=0;
        }else
        {
            $data_insert['start_balance_status']==3;
            $data_insert['start_balance']=0;
        }   
        $data_insert['notes']=$request->notes;    
        $data_insert['address']=$request->address;    
        $data_insert['active']=$request->active;    
        $data_insert['created_at']=date("Y-m-d H:i:s");
        $data_insert['added_by']=auth()->user()->id;
        $data_insert['com_code']=$com_code;
        $data_insert['date']=date("Y-m-d");

        $flag=insert(new Customer(),$data_insert);
        if($flag){
            //insert into accounts
            
        $data_insert_account['name']=$request->name;

        $data_insert_account['start_balance_status'] = $data_insert['start_balance_status'];
        $data_insert_account['start_balance'] = $data_insert['start_balance'];

        // if( $data_insert_account['start_balance_status']==1){
        //     if($request->start_balance>0){
        //         $data_insert_account['start_balance']=$request->start_balance*-1;    
        //     }
        // }  elseif($data_insert_account['start_balance_status']==2){
        //     if($request->start_balance<0){
        //         $data_insert_account['start_balance']=$request->start_balance*-1;    
        //     }
        // }elseif($data_insert_account['start_balance_status']==3){
        //     $data_insert_account['start_balance']=0;
        // }else
        // {
        //     $data_insert_account['start_balance_status']==3;
        //     $data_insert_account['start_balance']=0;
        // }   
        $customer_parent_account_number=get_field_value(new Admin_panel_setting(),'customer_parent_account_number',['com_code'=>$com_code]);

        $data_insert_account['notes']=$request->notes;    
        $data_insert_account['is_parent']=0;    
        $data_insert_account['account_number']=$data_insert['account_number']; 
        $data_insert_account['parent_account_number']=$customer_parent_account_number; 
        $data_insert_account['account_type']=3;
        $data_insert_account['address']=$request->address;    
        $data_insert_account['created_at']=date("Y-m-d H:i:s");
        $data_insert_account['added_by']=auth()->user()->id;
        $data_insert_account['com_code']=$com_code;
        $data_insert_account['other_table_FK']=$data_insert['customer_code'];// دا عشانلالا لما يغير اسممه في الجدول بتاعه مثلا يسمع في الصف بتاعه في جدول الحسابات
        $data_insert_account['date']=date("Y-m-d");
        $flag=insert(new Account(),$data_insert_account);
        }
        return redirect()->route('admin.customers.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        
    }
    catch(\Exception $ex){
    
        return redirect()->back()
        ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
        ->withInput();           
        }

} 


public function edit($id){
    $com_code=auth()->user()->com_code;
    $data=Customer::select()->where('com_code',$com_code)->find($id);
if(empty($data)or $data==null){
    return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما']);
}
return view('admin.customers.edit',['data'=>$data]);
}


public function update($id,CustomersRequestEdit $request){
    try{
    $com_code=auth()->user()->com_code;
    $data=get_cols_row_where(new Customer(),array("*"),array('id'=>$id,'com_code'=>$com_code));
    if(empty($data)){
    return redirect()->route('admin.customers.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    //check if not exsits
    $checkExistsForName=Customer::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();


    if(!empty($checkExistsForName)){
        return redirect()->back()
    ->with(['error'=>'اسم العميل مسجل من قبل'])
    ->withInput(); 
    }

    $data_to_update['name']=$request->name;    
    $data_to_update['address']=$request->address;    
    $data_to_update['notes']=$request->notes;    
    $data_to_update['active']=$request->active;  
        $data_to_update['updated_by']=auth()->user()->id;
        $data_to_update['updated_at']=date("Y-m-d H:i:s");
      $flag=  Customer::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
if($flag){
    $data_to_update_account['name']=$request->name;    
        $data_to_update_account['updated_by']=auth()->user()->id;
        $data_to_update_account['updated_at']=date("Y-m-d H:i:s");
        $flag=  Account::where(['com_code'=>$com_code,'account_number'=>$data['account_number'],'other_table_FK'=>$data['customer_code'],'account_type'=>3])->update($data_to_update_account);
    return redirect()->route('admin.customers.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);

}
    
    }catch(\Exception $ex){
    return redirect()->back()
    ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
    ->withInput();           
    }
}


public function delete($id){
    $com_code=auth()->user()->com_code;

    $data=get_cols_row_where(new Account(),['id'],['id'=>$id,'com_code'=>$com_code]);
    if(!empty($data)||$data!=null){

        $isDeleted=$data->delete();
        if($isDeleted){
return redirect()->route('admin.customers.index')->with(['success'=>'تم مسح الصف بنجاح']);

    }else{
        return redirect()->back()->with(['error'=>"لم يتم مسح البيانات"]);
    }
    }else{
        return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
}




    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $search_by_text = $request->search_by_text;
            $searchbyradio = $request->searchbyradio;




            if ($search_by_text != "") {
                if ($searchbyradio == "name") {
                    $field3 = "name";
                    $opertion3 = "like";
                    $value3 = "%{$search_by_text}%";
                } elseif ($searchbyradio == "account_number") {
                    $field3 = 'account_number';
                    $opertion3 = '=';
                    $value3 = $search_by_text;
                }elseif ($searchbyradio == "customer_code") {
                    $field3 = 'customer_code';
                    $opertion3 = '=';
                    $value3 = $search_by_text;
                }
            } else {
                $field3 = 'id';
                $opertion3 = '>';
                $value3 = 0;
            }


            $data = Customer::where($field3, $opertion3, $value3)->orderBy('id', 'DESC')->paginate(PADINATION_COUNT);
            $com_code = auth()->user()->com_code;
            if (!empty($data)) {
                foreach ($data as $info) {
                    $info->created_by_admin = Admin::where('id', $info->created_by)->value('name');
                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                    }
                }
                return view('admin.customers.search_ajax', ['data' => $data]);
            }


        }



    }

    





}

