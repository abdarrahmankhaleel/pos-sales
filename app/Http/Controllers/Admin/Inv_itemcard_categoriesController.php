<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inv_itemcard_categoriesRequest;
use Illuminate\Http\Request;
use App\Models\Inv_itemcard_categories;
use App\Models\Admin;
class Inv_itemcard_categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Inv_itemcard_categories::select()->orderby('id')->paginate(PADINATION_COUNT);
        if(!empty($data)){
            foreach($data as $info){
        $data->created_by_admin = Admin::where('id', $info->created_by)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
            }
        }
    }
    return view('admin.inv_itemcard_categories.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inv_itemcard_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Inv_itemcard_categoriesRequest $request){
        try{
        $com_code=auth()->user()->com_code;
        //check if not exsits
        $checkExists=Inv_itemcard_categories::where(['name'=>trim($request->name),'com_code'=>$com_code])->first();
        if($checkExists==null){
        $data['name']=$request->name;
        $data['active']=$request->active;
        $data['created_at']=date("Y-m-d H:i:s");
        $data['added_by']=auth()->user()->id;
        $data['com_code']=$com_code;
        $data['date']=date("Y-m-d");
        Inv_itemcard_categories::create($data);
        return redirect()->route('inv_itemcard_categories.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data=Inv_itemcard_categories::select()->find($id);
        if(empty($data)||$data==null){
            return redirect()->back()
           ->with(['error'=>'لا يمكن الوصول الى البيانات المطلوبة']); 
        };
           return view('admin.inv_itemcard_categories.edit',['data'=>$data]);
        }
        
        
        public function update($id,Inv_itemcard_categoriesRequest $request){
            try{
            $com_code=auth()->user()->com_code;
            $data=Inv_itemcard_categories::select()->find($id);
            if(empty($data)){
            return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
            //check if not exsits
            $checkExists=Inv_itemcard_categories::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();
            if($checkExists==null){
                $data_to_update['name']=$request->name;
                $data_to_update['active']=$request->active;
                $data_to_update['updated_by']=auth()->user()->id;
                $data_to_update['updated_at']=date("Y-m-d H:i:s");
                Inv_itemcard_categories::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
                return redirect()->route('inv_itemcard_categories.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
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
                $data=Inv_itemcard_categories::where('id',$id)->first();
                if(!empty($data)||$data!=null){
          
                    $isDeleted=$data->delete();
                    if($isDeleted){
           return redirect()->back()->with(['success'=>'تم مسح الصف بنجاح']);
          
                    }else{
                        return redirect()->back()->with(['error'=>"لم يتم مسح البيانات"   ]);
                    }
                }
            }

    /**
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
