<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use App\Http\Requests\Inv_uomRequest;
use App\Models\Inv_uom;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Models\Inv_uom_delivery;
use App\Http\Requests\AddInv_uom_deliveryRequest;
use App\Models\Inv_itemCard;

class Inv_UomController extends Controller

{
    public function index(){
        
        $data=Inv_uom::select()->orderby('id')->paginate(PADINATION_COUNT);
        if(!empty($data)){
        foreach($data as $info){
        $info->created_by_admin = Admin::where('id', $info->created_by)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }
    }
    return view('admin.inv_uom.index',['data'=>$data]);

}

public function create()
{
    return view('admin.inv_uom.create');
}


public function store(Inv_uomRequest $request){
    try{
    $com_code=auth()->user()->com_code;
    //check if not exsits
    $checkExists=Inv_uom::where(['name'=>trim($request->name),'com_code'=>$com_code])->first();
    if($checkExists==null){
    $data['name']=$request->name;
    $data['is_master']=$request->is_master;
    $data['active']=$request->active;
    $data['created_at']=date("Y-m-d H:i:s");
    $data['added_by']=auth()->user()->id;
    $data['com_code']=$com_code;
    $data['date']=date("Y-m-d");
    Inv_uom::create($data);
    return redirect()->route('admin.uoms.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
    }else{
    return redirect()->back()
    ->with(['error'=>'عفوا اسم الخزنة مسجل من قبل'])
    ->withInput(); 
    }
    }catch(\Exception $ex){
    return redirect()->back()
    ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
    ->withInput();           
    }
    } 


public function edit($id){
$data=Inv_uom::select()->find($id);
return view('admin.inv_uom.edit',['data'=>$data]);
}


public function update($id,Inv_uomRequest $request){
    try{
    $com_code=auth()->user()->com_code;
    $data=Inv_uom::select()->find($id);
    if(empty($data)){
    return redirect()->route('admin.uoms.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    //check if not exsits
    $checkExists=Inv_uom::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();
    if($checkExists==null){
     

        $data_to_update['name']=$request->name;
        $data_to_update['is_master']=$request->is_master;
        $data_to_update['active']=$request->active;
        $data_to_update['updated_by']=auth()->user()->id;
        $data_to_update['updated_at']=date("Y-m-d H:i:s");
        Inv_uom::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
        return redirect()->route('admin.uoms.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
    }else{
    return redirect()->back()
    ->with(['error'=>'عفوا اسم الخزنة مسجل من قبل'])
    ->withInput(); 
    }
    }catch(\Exception $ex){
    return redirect()->back()
    ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
    ->withInput();           
    }
    } 





    public function ajax_search(Request $request){
        if($request->ajax()){
        $search_by_text=$request->search_by_text;
        $is_master_search=$request->is_master_search;
        if ($search_by_text=="") {
          $field1='id';
          $opertion1='>';
          $value1=0;
        }else{
            $field1='name';
            $opertion1='LIKE';
            $value1="%{$search_by_text}%";
        }
    
        if ($is_master_search=="all") {
            $field2='id';
            $opertion2='>';
            $value2=0;
          }else{
              $field2= 'is_master';
              $opertion2 ='=';
              $value2=$is_master_search;
          }
        $data=Inv_uom::where($field1, $opertion1, $value1)->where($field2,$opertion2,$value2)->orderBy('id','DESC')->paginate(PADINATION_COUNT);
        return view('admin.inv_uom.search_ajax',['data'=>$data]);
        }
        }
    



    public function delete($id){
        $data=Inv_uom::where('id',$id)->first();
        if(!empty($data)||$data!=null){

            $isDeleted=$data->delete();
            if($isDeleted){
   return redirect()->back()->with(['success'=>'تم مسح الصف بنجاح']);

            }else{
                return redirect()->back()->with(['error'=>"لم يتم مسح البيانات"]);
            }
        }
    }

}

