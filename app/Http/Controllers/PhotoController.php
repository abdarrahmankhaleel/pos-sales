<?php

namespace App\Http\Controllers;

use App\Models\Name;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\List_;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name='ali';
        $age=4;
        $arr=[
            ['name'=>'ali','age'=>34],
            ['name'=>'atef','age'=>30],
            ['name'=>'adel','age'=>59]
        ];
     //   return view("atef",compact('age'),compact('name'));
     //  return view('atef',['omor'=>$age,'ism'=>$name]); //يفضل اسامي الكيز نفسها بس اععملت هيك عشان تتعلم بس
     
        $data_names=Name::all();
        var_dump($data_names);
     return view('atef',['age'=>$age,'name'=>$name,'arr'=>$arr,'data_names'=>$data_names]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
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
