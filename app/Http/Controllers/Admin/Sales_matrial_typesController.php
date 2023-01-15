<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use App\Models\Sales_matrial_types;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Models\Sales_matrial_types_delivery;
use App\Http\Requests\Sales_matrial_typesRequest;

class Sales_matrial_typesController extends Controller

{
    public function index(){
        
        $Sales_matrial_types=Sales_matrial_types::select()->orderby('id')->paginate(PADINATION_COUNT);
        if(!empty($data)){
            foreach($Sales_matrial_types as $info){
        $data->created_by_admin = Admin::where('id', $info->created_by)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }
    }
    return view('admin.sales_matrial_types.index',['Sales_matrial_types'=>$Sales_matrial_types]);

}

public function create()
{
    return view('admin.sales_matrial_types.create');
}

public function store(Sales_matrial_typesRequest $request){
   try{
   $com_code=auth()->user()->com_code;
   //check if not exsits
   $checkExists=Sales_matrial_types::where(['name'=>trim($request->name),'com_code'=>$com_code])->first();
   if($checkExists==null){
   $data['name']=$request->name;
   $data['active']=$request->active;
   $data['created_at']=date("Y-m-d H:i:s");
   $data['added_by']=auth()->user()->id;
   $data['com_code']=$com_code;
   $data['date']=date("Y-m-d");
   Sales_matrial_types::create($data);
   return redirect()->route('admin.sales_matrial_types.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
   }else{
   return redirect()->back()
   ->with(['error'=>'عفوا اسم الفئة مسجلة من قبل'])
   ->withInput(); 
   }
   }catch(\Exception $ex){
   return redirect()->back()
   ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
   ->withInput();           
   }
   } 


public function edit($id){
$data=Sales_matrial_types::select()->find($id);
if(empty($data)||$data==null){
    return redirect()->back()
   ->with(['error'=>'لا يمكن الوصول الى البيانات المطلوبة']); 
};
   return view('admin.sales_matrial_types.edit',['data'=>$data]);
}


public function update($id,Sales_matrial_typesRequest $request){
    try{
    $com_code=auth()->user()->com_code;
    $data=Sales_matrial_types::select()->find($id);
    if(empty($data)){
    return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    //check if not exsits
    $checkExists=Sales_matrial_types::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();
    if($checkExists==null){
        $data_to_update['name']=$request->name;
        $data_to_update['active']=$request->active;
        $data_to_update['updated_by']=auth()->user()->id;
        $data_to_update['updated_at']=date("Y-m-d H:i:s");
        Sales_matrial_types::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
        return redirect()->route('admin.sales_matrial_types.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
    }else{
    return redirect()->back()
    ->with(['error'=>'عفوا اسم الفئة مسجل من قبل'])
    ->withInput(); 
    }
    }catch(\Exception $ex){
    return redirect()->back()
    ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
    ->withInput();           
    }
    }
    
    public function delete($id){
        $data=Sales_matrial_types::where('id',$id)->first();
        if(!empty($data)||$data!=null){
  
            $isDeleted=$data->delete();
            if($isDeleted){
   return redirect()->back()->with(['success'=>'تم مسح الصف بنجاح']);
  
            }else{
                return redirect()->back()->with(['error'=>"لم يتم مسح البيانات"   ]);
            }
        }
    }

}



    













