<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsRequest;
use App\Models\Admin;
use App\Models\Inv_uom;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Http\Requests\AccountsRequestUpdate;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Customer;

class AccountsController extends Controller

{
    public function index(){
        $com_code=auth()->user()->com_code;
        //$data=Account::select()->orderby('id')->paginate(PADINATION_COUNT);
        $account_types=get_cols_where(new AccountType(),array('id','name'),array('active'=>1),'id','ASC');

        $data=get_cols_where_p(new Account(),array("*"),array('com_code'=>$com_code,'is_archived'=>0),'id','ASC',PADINATION_COUNT);
        if(!empty($data)){
        foreach($data as $info){
        $info->created_by_admin = Admin::where('id', $info->created_by)->value('name');
        $info->account_type_name= AccountType::where('id', $info->account_type)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
        }
        $info->account_parent_name= ($info->parent_account_number!=null and $info->is_parent==0)?Account::where('account_number', $info->parent_account_number)->value('name'):"لا يوجد";
    }
    

    }
    return view('admin.accounts.index',['data'=>$data,'account_types'=>$account_types]);

}

public function create()
{
    $com_code=auth()->user()->com_code;

    $account_types=get_cols_where(new AccountType(),array('id','name'),array('active'=>1,'relatediternalaccounts'=>0),'id','ASC');
    $accounts_parent=get_cols_where(new Account(),array('account_number','name'),array('is_parent'=>1,'is_archived'=>0,'com_code'=>$com_code),'id','ASC');
    return view('admin.accounts.create',['account_types'=>$account_types,'accounts_parent'=>$accounts_parent]);
}


public function store(AccountsRequest $request){
  
    try{
        $com_code=auth()->user()->com_code;
        //check if not exsits for name
        //$checkExistsForName=Account::where(['name'=>trim($request->name),'com_code'=>$com_code])->first();
        $checkExistsForName=get_cols_row_where(new Account(),array("id"),array('name'=>trim($request->name),'com_code'=>$com_code));

        if(!empty($checkExistsForName)){
            return redirect()->back()
        ->with(['error'=>'اسم الحساب مسجل من قبل'])
        ->withInput(); 
        }
        //end check if not exsits for name
//set account number
$row = get_cols_where_row_orderby(new Account(), array("account_number"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['account_number'] = $row['account_number'] + 1;
} else {
$data_insert['account_number'] = 1;
}




        $data_insert['is_parent']=$request->is_parent;
        if($data_insert['is_parent']==0){
        $data_insert['parent_account_number']=$request->parent_account_number;
        }
        $data_insert['name']=$request->name;    
        $data_insert['account_type']=$request->account_type;    
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
        $data_insert['notes']=$request->uom_id;    
        $data_insert['is_archived']=$request->is_archived;    
        $data_insert['created_at']=date("Y-m-d H:i:s");
        $data_insert['added_by']=auth()->user()->id;
        $data_insert['com_code']=$com_code;
        $data_insert['date']=date("Y-m-d");


        Account::create($data_insert);
        return redirect()->route('admin.accounts.index')->with(['success'=>'تم اضافة البيانات بنجاح']);

    }
    catch(\Exception $ex){
    
        return redirect()->back()
        ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
        ->withInput();           
        }

} 


public function edit($id){
$com_code=auth()->user()->com_code;
$data=Account::select()->where('com_code',$com_code)->find($id);

$account_types=get_cols_where(new AccountType(),array('id','name'),array('active'=>1),'id','ASC');
$accounts_parent=get_cols_where(new Account(),array('account_number','name'),array('is_parent'=>1,'is_archived'=>0,'com_code'=>$com_code),'id','ASC');
return view('admin.accounts.edit',['account_types'=>$account_types,'accounts_parent'=>$accounts_parent,'data'=>$data]);
}


public function update($id,AccountsRequestUpdate $request){
    try{
    $com_code=auth()->user()->com_code;
    $data=get_cols_row_where(new Account(),array("*"),array('id'=>$id,'com_code'=>$com_code));
    if(empty($data)){
    return redirect()->route('admin.accounts.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    //check if not exsits
    $checkExistsForName=Account::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();


    if(!empty($checkExistsForName)){
        return redirect()->back()
    ->with(['error'=>'اسم الحساب مسجل من قبل'])
    ->withInput(); 
    }
    $data_to_update['is_parent']=$request->is_parent;
    if($data_to_update['is_parent']==0){
    $data_to_update['parent_account_number']=$request->parent_account_number;
    }
    $data_to_update['name']=$request->name;    
    $data_to_update['account_type']=$request->account_type;    
    $data_to_update['notes']=$request->uom_id;    
    $data_to_update['is_archived']=$request->is_archived;  
        $data_to_update['updated_by']=auth()->user()->id;
        $data_to_update['updated_at']=date("Y-m-d H:i:s");
      $flag=  Account::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
      if($flag){
        if($data_to_update['account_type']==3){
            $data_to_update_customer['name']=   $data_to_update['name'];    
            $data_to_update_customer['updated_by']=auth()->user()->id;
            $data_to_update_customer['updated_at']=date("Y-m-d H:i:s");
            $flag=  Customer::where(['com_code'=>$com_code,'account_number'=>$data['account_number'],'customer_code'=>$data['other_table_FK'],])->update($data_to_update_customer);
        }
      }
        return redirect()->route('admin.accounts.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
    
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
return redirect()->route('admin.accounts.index')->with(['success'=>'تم مسح الصف بنجاح']);

    }else{
        return redirect()->back()->with(['error'=>"لم يتم مسح البيانات"]);
    }
    }else{
        return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
}




public function ajax_search(Request $request){
    if($request->ajax()){
    $search_by_text=$request->search_by_text;
    $account_type_search=$request->account_type_search;
    $is_parent_search=$request->is_parent_search;
    $searchbyradio=$request->searchbyradio;

    if ($is_parent_search=="all") {
        $field1='id';
        $opertion1='>';
        $value1=0;
      }else{
          $field1='is_parent';
          $opertion1='=';
          $value1=$is_parent_search;
      }

      if ($account_type_search=="all") {
          $field2='id';
          $opertion2='>';
          $value2=0;
        }else{
            $field2= 'account_type';
            $opertion2 ='=';
            $value2=$account_type_search;
        }

      if ($search_by_text!="") {
        if($searchbyradio=="name"){
            $field3='name';
            $opertion3='=';
            $value3=$search_by_text;
        }elseif($searchbyradio=="item_code"){
            $field3='account_number';
            $opertion3='=';
            $value3=$search_by_text;
        }
      }else{
        $field3='id';
        $opertion3='>';
        $value3=0;
    }

    
    $data=Account::where($field1, $opertion1, $value1)->where($field2, $opertion2, $value2)->where($field3, $opertion3, $value3)->orderBy('id','DESC')->paginate(PADINATION_COUNT);
    if (!empty($data)) {
        $account_types=get_cols_where(new AccountType(),array('id','name'),array('active'=>1),'id','ASC');

        foreach($data as $info){
            $info->created_by_admin = Admin::where('id', $info->created_by)->value('name');
            $info->account_type_name= AccountType::where('id', $info->account_type)->value('name');
            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
            $info->account_parent_name= ($info->parent_account_number!=null and $info->is_parent==0)?Account::where('account_number', $info->parent_account_number)->value('name'):"لا يوجد";
        }
        }
    return view('admin.accounts.search_ajax',['data'=>$data,'account_types'=>$account_types]);   


      }
       

     }


    





}

