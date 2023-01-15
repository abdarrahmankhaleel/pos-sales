<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use App\Http\Requests\TreasuriesRequest;
use App\Models\Treasuries;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Models\Treasuries_delivery;
use App\Http\Requests\Addtreasuries_deliveryRequest;
class TreasuriesController extends Controller

{
    public function index(){
        
        $data=Treasuries::select()->orderby('id')->paginate(PADINATION_COUNT);
        if(!empty($data)){
        foreach($data as $info){
        $info->created_by_admin = Admin::where('id', $info->created_by)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }
    }
    return view('admin.treasuries.index',['data'=>$data]);

}

public function create()
{
    return view('admin.treasuries.create');
}


public function store(TreasuriesRequest $request){
    try{
    $com_code=auth()->user()->com_code;
    //check if not exsits
    $checkExists=Treasuries::where(['name'=>trim($request->name),'com_code'=>$com_code])->first();
    if($checkExists==null){
    if($request->is_master==1){
    $checkExists_isMaster=Treasuries::where(['is_master'=>1,'com_code'=>$com_code])->first();
    if($checkExists_isMaster!=null){
    return redirect()->back()
    ->with(['error'=>'عفوا هناك خزنة رئيسية بالفعل مسجلة من قبل لايمكن ان يكون هناك اكثر من خزنة رئيسية'])
    ->withInput(); }
    }
    $data['name']=$request->name;
    $data['is_master']=$request->is_master;
    $data['last_isal_exhcange']=$request->last_isal_exhcange;
    $data['last_isal_collect']=$request->last_isal_collect;
    $data['active']=$request->active;
    $data['created_at']=date("Y-m-d H:i:s");
    $data['added_by']=auth()->user()->id;
    $data['com_code']=$com_code;
    $data['date']=date("Y-m-d");
    Treasuries::create($data);
    return redirect()->route('admin.treasuries.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
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
$data=Treasuries::select()->find($id);
return view('admin.treasuries.edit',['data'=>$data]);
}


public function update($id,TreasuriesRequest $request){
    try{
    $com_code=auth()->user()->com_code;
    $data=Treasuries::select()->find($id);
    if(empty($data)){
    return redirect()->route('admin.treasuries.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    //check if not exsits
    $checkExists=Treasuries::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();
    if($checkExists==null){
        if($request->is_master==1){
        $checkExists_isMaster=Treasuries::where(['is_master'=>1,'com_code'=>$com_code])->where('id',"!=",$id)->first();
        if($checkExists_isMaster!=null){
        return redirect()->back()
        ->with(['error'=>'عفوا هناك خزنة رئيسية بالفعل مسجلة من قبل لايمكن ان يكون هناك اكثر من خزنة رئيسية'])
        ->withInput(); }
        }

        $data_to_update['name']=$request->name;
        $data_to_update['is_master']=$request->is_master;
        $data_to_update['last_isal_exhcange']=$request->last_isal_exhcange;
        $data_to_update['last_isal_collect']=$request->last_isal_collect;
        $data_to_update['active']=$request->active;
        $data_to_update['updated_by']=auth()->user()->id;
        $data_to_update['updated_at']=date("Y-m-d H:i:s");
        Treasuries::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
        return redirect()->route('admin.treasuries.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
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
        $data=Treasuries::where('name','LIKE',"%{$search_by_text}%")->orderBy('id','DESC')->paginate(PADINATION_COUNT);
        return view('admin.treasuries.search_ajax',['data'=>$data]);
        }
        }

    public function details($id){
    $com_code=auth()->user()->com_code;
        $data=Treasuries::select()->find($id); 
        if(empty($data)){
            return redirect()->back()->with(['error'=>'لا يمكن الوصول الى البيانات المطلوبة']);
        }
        if($data->added_by>0  && $data->added_by!=null){
            $data->updated_by_admin=Admin::select()->where(['id'=>$data->added_by,'com_code'=>$com_code])->value('name');
        }
        $data->added_by_admin=Admin::where(['id'=>$data->added_by])->value('name');
        $treasuries_delivery=Treasuries_delivery::select()->where(['treasuries_id'=>$id,'com_code'=>$com_code])->get();
        foreach ($treasuries_delivery as $info) {
            # code...
            $info['treasuries_delivery_name']=
            Treasuries::where(['id'=>$info->treasuries_can_delivery_id,
            'com_code'=>$com_code])->value('name');
            $info['added_by_admin']=Admin::where(['id'=>$info->added_by,'com_code'=>$com_code])->value('name');
        }         
        return view('admin.treasuries.details',['data'=>$data,'treasuries_delivery'=>$treasuries_delivery]);

    }


    public function Add_treasuries_delivery($id){
    $com_code=auth()->user()->com_code;

        $data=Treasuries::select('id','name')->find($id);
        if(empty($data)){
            return redirect()->back()->with(['error'=>'لا يوجد بيانات']);
        }
        $Treasuries=Treasuries::select('id','name')->where(['active'=>1,'com_code'=>$com_code])->get();
        return view('admin.treasuries.Add_treasuries_delivery',['data'=>$data,'Treasuries'=>$Treasuries]);
    }

    public function store_treasuries_delivery($id,Addtreasuries_deliveryRequest $request){
        $com_code=auth()->user()->com_code;
        $Treasury=Treasuries::select('id','name')->find($id);
        if($Treasury==null||empty($Treasury)){
            return redirect()->route('admin.treasuries.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!'])
            ->withInput();
    }
        $checkExists=Treasuries_delivery::where(['treasuries_can_delivery_id'=>$request->treasuries_can_delivery_id,
        'treasuries_id'=>$Treasury->id,'com_code'=>$com_code])->first();
        if($checkExists!=null||!empty($checkExists)){
                return redirect()->back()->with(['error'=>"$Treasury->name توجد هذه الخزنة الفرعية لهذه الخزنة"   ])
                ->withInput();
    
        }
        $data['treasuries_id']=$Treasury->id;
        $data['treasuries_can_delivery_id']=$request->treasuries_can_delivery_id;
        $data['created_at']=date("Y-m-d H:i:s");
        $data['added_by']=auth()->user()->id;
        $data['com_code']=$com_code;
        Treasuries_delivery::create($data);
    return redirect()->route('admin.treasuries.details',['id'=>$id])->with(['success'=>'تم اضافة البيانات بنجاح']);
    }

    public function delete_treasuries_delivery($id){
        $data=Treasuries_delivery::where('id',$id)->first();
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

