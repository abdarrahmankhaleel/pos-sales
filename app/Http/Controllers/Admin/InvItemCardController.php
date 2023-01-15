<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inv_itemcard_categoriessRequest;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\Inv_itemcard_categories;
use App\Http\Requests\ItemcardRequest;
class InvItemCardController extends Controller
{

    public function index()
    {
    $com_code = auth()->user()->com_code;
    $data = get_cols_where_p(new Inv_itemCard(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PADINATION_COUNT);
    if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = get_field_value(new Admin(), 'name', array('id' => $info->added_by));
    $info->inv_itemcard_categories_name = get_field_value(new Inv_itemcard_categories(), 'name', array('id' => $info->inv_itemcard_categories_id));
    $info->Uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->uom_id));
    $info->retail_uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->retail_uom_id));
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = get_field_value(new Admin(), 'name', array('id' => $info->updated_by));
    }
    }
    }
    $inv_itemcard_categories = get_cols_where(new Inv_itemcard_categories(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    return view('admin.inv_itemCard.index', ['data' => $data, 'inv_itemcard_categories' => $inv_itemcard_categories]);
    }
    public function create()
    {
    $com_code = auth()->user()->com_code;
    $inv_itemcard_categories = get_cols_where(new Inv_itemcard_categories(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    $inv_uoms_parent = get_cols_where(new Inv_uom(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_master' => 1), 'id', 'DESC');
    $inv_uoms_child = get_cols_where(new Inv_uom(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_master' => 0), 'id', 'DESC');
    $item_card_data = get_cols_where(new Inv_itemCard(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    return view('admin.inv_itemCard.create', ['inv_itemcard_categories' => $inv_itemcard_categories, 'inv_uoms_parent' => $inv_uoms_parent, 'inv_uoms_child' => $inv_uoms_child, 'item_card_data' => $item_card_data]);
    }

    public function store(ItemcardRequest $request)
    {
        
        try{
            $com_code=auth()->user()->com_code;
            //check if not exsits for name
            $checkExists=Inv_itemcard_categories::where(['name'=>trim($request->name),'com_code'=>$com_code])->first();
            if(!empty($checkExists)){
                return redirect()->back()
            ->with(['error'=>'اسم الصنف مسجل من قبل'])
            ->withInput(); 
            }
            //end check if not exsits for name


           $rowLastId= get_cols_row_where(new Inv_itemCard(),array("id"),array("com_code"=>$com_code),"id","DESC");
           if(!empty($rowLastId)){
               $data_insert['item_code']  =$rowLastId['id']+1;
           }else{
            $data_insert['item_code']=1;
           }
           
           //check if not exsits for barcode
            if($request->barcode!=""){
                $checkExists=Inv_itemcard_categories::where(['barcode'=>trim($request->barcode),'com_code'=>$com_code])->first();
                if(!empty($checkExists)){
                    return redirect()->back()
                ->with(['error'=>'باركود الصنف مسجل من قبل'])
                ->withInput(); 
                }else{
                $data_insert['barcode']=$request->barcode;    
                }
            }else{
                $data_insert['barcode']="item".$data_insert['item_code'];
            }
            //end check if not exsits for barcode



            $data_insert['does_has_retailunit']=$request->does_has_retailunit;


            if($data_insert['does_has_retailunit']==1){
            $data_insert['retail_uom_id']=$request->retail_uom_id;
            $data_insert['retail_uom_quntToParent']=$request->retail_uom_quntToParent;
            $data_insert['price_retail']=$request->price_retail;
            $data_insert['nos_gomla_price_retail']=$request->nos_gomla_price_retail;
            $data_insert['gomla_price_retail']=$request->gomla_price_retail;
            $data_insert['cost_price_retail']=$request->cost_price_retail;
            }



            $data_insert['name']=$request->name;    
            $data_insert['item_type']=$request->item_type;    
            $data_insert['inv_itemcard_categories_id']=$request->inv_itemcard_categories_id;    
            $data_insert['parent_inv_itemcard_id']=$request->parent_inv_itemcard_id;    
            $data_insert['uom_id']=$request->uom_id;    
            $data_insert['price']=$request->price;    
            $data_insert['nos_gomla_price']=$request->nos_gomla_price;    
            $data_insert['gomla_price']=$request->gomla_price;    
            $data_insert['cost_price']=$request->cost_price;    
            $data_insert['has_fixced_price']=$request->has_fixced_price;    
            $data_insert['gomla_price']=$request->gomla_price;    
            $data_insert['gomla_price']=$request->gomla_price;    
            $data_insert['gomla_price']=$request->gomla_price;    
            $data_insert['active']=$request->active;
            $data_insert['created_at']=date("Y-m-d H:i:s");
            $data_insert['added_by']=auth()->user()->id;
            $data_insert['com_code']=$com_code;
            $data_insert['date']=date("Y-m-d");

            if($request->has('Item_img')){
                $request->validate([
                    'Item_img'=>'required|mimes:png,jpg,jpeg|max:2000',
                ]);
        
                $the_new_file_path=uploadImage('assets/admin/uploads',$request->Item_img);
                $data_insert['photo']=$the_new_file_path;
        
            }

            Inv_itemCard::create($data_insert);
            return redirect()->route('admin.itemcard.index')->with(['success'=>'تم اضافة البيانات بنجاح']);

        }
        catch(\Exception $ex){
        
            return redirect()->back()
            ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
            ->withInput();           
            }
    }

    public function edit($id){
        $data=get_cols_row_where(new Inv_itemCard(),array("*"),array('id'=>$id));
        if(empty($data)||$data==null){
            return redirect()->back()
           ->with(['error'=>'لا يمكن الوصول الى البيانات المطلوبة']); 
        };
        $com_code = auth()->user()->com_code;
        $inv_itemcard_categories = get_cols_where(new Inv_itemcard_categories(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
        $inv_uoms_parent = get_cols_where(new Inv_uom(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_master' => 1), 'id', 'DESC');
        $inv_uoms_child = get_cols_where(new Inv_uom(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_master' => 0), 'id', 'DESC');
        $item_card_data = get_cols_where(new Inv_itemCard(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
        return view('admin.inv_itemCard.edit', ['data'=>$data,'inv_itemcard_categories' => $inv_itemcard_categories, 'inv_uoms_parent' => $inv_uoms_parent, 'inv_uoms_child' => $inv_uoms_child, 'item_card_data' => $item_card_data]);
        }


        public function update($id,ItemcardRequest $request){
            try{
            $com_code=auth()->user()->com_code;
            $data=Inv_itemCard::select()->find($id);
            if(empty($data)){
            return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }

        //check if not exsits for barcode
            $checkExistsforbarcode=Inv_itemCard::where(['barcode'=>trim($request->barcode),'com_code'=>$com_code])->where("id","!=",$id)->first();
            if(!empty($checkExistsforbarcode)){
                return redirect()->back()
            ->with(['error'=>'باركود الصنف مسجل من قبل'])
            ->withInput(); 
            }else{
            $data_to_update['barcode']=$request->barcode;    
            }
  
        //end check if not exsits for barcode


            //check if not exsits for name
            $checkExistsForName=Inv_itemCard::where(['name'=>trim($request->name),'com_code'=>$com_code])->where('id',"!=",$id)->first();
            if(!empty($checkExistsForName)){
                return redirect()->back()
            ->with(['error'=>'باركود الصنف مسجل من قبل'])
            ->withInput(); 
            }else{
            $data_to_update['name']=$request->name;    
            }


   
            $data_to_update['does_has_retailunit']=$request->does_has_retailunit;


            if($data_to_update['does_has_retailunit']==1){
            $data_to_update['retail_uom_id']=$request->retail_uom_id;
            $data_to_update['retail_uom_quntToParent']=$request->retail_uom_quntToParent;
            $data_to_update['price_retail']=$request->price_retail;
            $data_to_update['nos_gomla_price_retail']=$request->nos_gomla_price_retail;
            $data_to_update['gomla_price_retail']=$request->gomla_price_retail;
            $data_to_update['cost_price_retail']=$request->cost_price_retail;
            }else{
                $data_to_update['retail_uom_id']=null;
                $data_to_update['retail_uom_quntToParent']=null;
                $data_to_update['price_retail']=null;
                $data_to_update['nos_gomla_price_retail']=null;
                $data_to_update['gomla_price_retail']=null;
                $data_to_update['cost_price_retail']=null;
            }



            $data_to_update['name']=$request->name;    
            $data_to_update['item_type']=$request->item_type;    
            $data_to_update['inv_itemcard_categories_id']=$request->inv_itemcard_categories_id;    
            $data_to_update['parent_inv_itemcard_id']=$request->parent_inv_itemcard_id;    
            $data_to_update['uom_id']=$request->uom_id;    
            $data_to_update['price']=$request->price;    
            $data_to_update['nos_gomla_price']=$request->nos_gomla_price;    
            $data_to_update['gomla_price']=$request->gomla_price;    
            $data_to_update['cost_price']=$request->cost_price;    
            $data_to_update['has_fixced_price']=$request->has_fixced_price;    
            $data_to_update['gomla_price']=$request->gomla_price;    
            $data_to_update['gomla_price']=$request->gomla_price;    
            $data_to_update['gomla_price']=$request->gomla_price;    
            $data_to_update['active']=$request->active;
            $data_to_update['created_at']=date("Y-m-d H:i:s");
            $data_to_update['added_by']=auth()->user()->id;
            $data_to_update['com_code']=$com_code;
            $data_to_update['date']=date("Y-m-d");
            $oldImg=$data->photo;
            if($request->has('photo')){
                $request->validate([
                    'photo'=>'required|mimes:png,jpg,jpeg|max:2000',
                ]);
        
                $the_new_file_path=uploadImage('assets/admin/uploads',$request->photo);
                $data_to_update['photo']=$the_new_file_path;
                if(file_exists('assets/admin/uploads/'.$oldImg) and !empty($oldImg)){
                    unlink('assets/admin/uploads/'.$oldImg);
                }
                
            }
                $data_to_update['updated_by']=auth()->user()->id;
                $data_to_update['updated_at']=date("Y-m-d H:i:s");
                Inv_itemCard::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
                return redirect()->route('admin.itemcard.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
            }
            catch(\Exception $ex){
            return redirect()->back()
            ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
            ->withInput();           
             }
        }



        public function delete($id){
            $data=Inv_itemCard::where('id',$id)->first();
            if(!empty($data)||$data!=null){
    
                $isDeleted=$data->delete();
                if($isDeleted){
       return redirect()->back()->with(['success'=>'تم مسح الصف بنجاح']);
    
                }else{
                    return redirect()->back()->with(['error'=>"لم يتم مسح البيانات"]);
                }
            }
        }


        public function show($id){
            $data=get_cols_row_where(new Inv_itemCard(),array("*"),array('id'=>$id));
            if(empty($data)||$data==null){
                return redirect()->back()
               ->with(['error'=>'لا يمكن الوصول الى البيانات المطلوبة']); 
            };

            $data['added_by_admin'] = get_field_value(new Admin(), 'name', array('id' => $data['added_by']));
            $data['inv_itemcard_categories_name'] = get_field_value(new Inv_itemcard_categories(), 'name', array('id' => $data['inv_itemcard_categories_id']));
            $data['inv_itemcard_parent_name'] = get_field_value(new Inv_itemCard(),'name', array('id' => $data['parent_inv_itemcard_id']));
            $data['Uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $data['uom_id']));
            if($data['does_has_retailunit']==1){
                $data['retail_uom_name'] = get_field_value(new Inv_uom(), 'name', array('id' => $data['retail_uom_id']));
            }
            if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
                $data['updated_by_admin ']= get_field_value(new Admin(), 'name', array('id' => $data['updated_by']));
                $data['com_code'] = auth()->user()->com_code;
            return view('admin.inv_itemCard.show',['data'=>$data]);
        }


}





    public function ajax_search(Request $request){
        if($request->ajax()){
        $search_by_text=$request->search_by_text;
        $searchbyradio=$request->searchbyradio;
        $item_type=$request->item_type;
        $inv_itemcard_categories_id=$request->inv_itemcard_categories_id;
        if ($item_type=="all") {
          $field1='id';
          $opertion1='>';
          $value1=0;
        }else{
            $field1='item_type';
            $opertion1='=';
            $value1=$item_type;
        }

        if ($inv_itemcard_categories_id=="all") {
            $field2='id';
            $opertion2='>';
            $value2=0;
          }else{
              $field2= 'inv_itemcard_categories_id';
              $opertion2 ='=';
              $value2=$inv_itemcard_categories_id;
          }



          if ($search_by_text!="") {
            if($searchbyradio=="name"){
                $field3='name';
                $opertion3='LIKE';
                $value3="%{$search_by_text}%";
            }elseif($searchbyradio=="barcode"){
                $field3='barcode';
                $opertion3='=';
                $value3=$search_by_text;
            }elseif($searchbyradio=="item_code"){
                $field3='item_code';
                $opertion3='=';
                $value3=$search_by_text;
            }
          }else{
            $field3='id';
            $opertion3='>';
            $value3=0;
        }

        
        $data=Inv_itemCard::where($field1, $opertion1, $value1)->where($field2,$opertion2,$value2)->where($field3, $opertion3, $value3)->orderBy('id','DESC')->paginate(PADINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info) {
            $info->added_by_admin = get_field_value(new Admin(), 'name', array('id' => $info->added_by));
            $info->inv_itemcard_categories_name = get_field_value(new Inv_itemcard_categories(), 'name', array('id' => $info->inv_itemcard_categories_id));
            $info->Uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->uom_id));
            $info->retail_uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->retail_uom_id));
            if ($info->updated_by > 0 and $info->updated_by != null) {
            $info->updated_by_admin = get_field_value(new Admin(), 'name', array('id' => $info->updated_by));
            }
            }
            }
        return view('admin.inv_itemCard.search_ajax',['data'=>$data]);   


          }
           
  
         }



        }



