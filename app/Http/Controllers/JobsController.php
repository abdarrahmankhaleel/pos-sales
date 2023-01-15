<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Http\Requests\jobsCreateRequest;
use App\Http\Requests\updateJobRequest;
class JobsController extends Controller
{
public function index(){
    $data=Job::select("*")->orderby("id","ASC")->paginate(10);

    return view('index',['data'=>$data]);
}    

public function create(){

    return view('create');
}    

// method post 

public function store(jobsCreateRequest $request){
   $dataToInsert['name']= $request->job_name;
   $dataToInsert['active']= $request->job_active;
   $dataToInsert['created_at']= date("Y-m-d H-i-s");
   Job::create($dataToInsert);
   return redirect()->route('Jobsindex')->with('succ','added successfully');
}

public function edit($id){
    $data=Job::select("*")->find($id);
    return view('edit',['data'=>$data]);
}
public function update($id,updateJobRequest $request){
$dataToUpdate['name']=$request->job_name;
$dataToUpdate['active']=$request->job_active;
$dataToInsert['created_at']= date("Y-m-d H-i-s");
Job::where(['id'=>$id])->update($dataToUpdate);
return redirect()->route('Jobsindex')->with('succ','updated successfully',3);
}
public function delete($id){
Job::where(['id'=>$id])->delete();
return redirect()->route('Jobsindex')->with('succ','deleted successfully',3);
}


public function ajax_search(Request $request){
if($request->ajax()){
    $searchbyjobname= $request->searchbyjobname;
    $data=Job::where("name","like","%{$searchbyjobname}%")->orderby("id","ASC")->paginate(1);
    return view('search_ajax',['data'=>$data]);
}
}

}
