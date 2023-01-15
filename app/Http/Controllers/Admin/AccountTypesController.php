<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use App\Models\Store;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Http\Requests\StoresRequest;
use App\Models\AccountType;

class AccountTypesController extends Controller

{
    public function index(){
        
        $data=AccountType::select()->orderby('id','ASC')->get();
        return view('admin.accountTypes.index',['data'=>$data]);

}


}



    













