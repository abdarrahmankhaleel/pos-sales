<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin_panel_settings_update_Request;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Account;
use Illuminate\Http\Request;

class Admin_panel_settingsController extends Controller
{
    public function index(){
        $data = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
        $data->customer_parent_account_number_name= Account::where('account_number', $data->customer_parent_account_number)->value('name');

        if (!empty($data)) {
        if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
        $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
    }
}
return view('admin.admin_panel_settings.index', ['data' => $data]);
}



public function edit(){
    $com_code=auth()->user()->com_code;
    $accounts_parent=get_cols_where(new Account(),array('account_number','name'),array('is_parent'=>1,'is_archived'=>0,'com_code'=>$com_code),'id','ASC');
    $data = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
    return view('admin.admin_panel_settings.edit', ['data' => $data,'accounts_parent'=>$accounts_parent]);

}

public function update(admin_panel_settings_update_Request $request){
try {
    $dataInDb = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
    $dataInDb->system_name=$request->system_name;
    $dataInDb->phone=$request->phone;
    $dataInDb->address=$request->address;
    $dataInDb->general_alert=$request->general_alert;
    $dataInDb->updated_by=$request->update_by;
    $dataInDb->customer_parent_account_number=$request->customer_parent_account_number;
    $dataInDb->updated_at=date('Y-m-d H:i:s');
    $oldImg=$dataInDb->photo;
    if($request->has('photo')){
        $request->validate([
            'photo'=>'required|mimes:png,jpg,jpeg|max:2000',
        ]);

        $the_new_file_path=uploadImage('assets/admin/uploads',$request->photo);
        $dataInDb->photo=$the_new_file_path;
        if(file_exists('assets/admin/uploads/'.$oldImg)){
            unlink('assets/admin/uploads/'.$oldImg);
        }

    }
    $dataInDb->save();
    return redirect()->route('admin.panalsettings.index')->with(['success'=>'تم تحديث البيانات بنجاح']);


} catch (\Exception $ex) {
    return redirect()->route('admin.panalsettings.index')->with(['error'=>'يوجد خطا ما'.$ex->getMessage()]);
}
}

}