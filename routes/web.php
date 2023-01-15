<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('admin.login');
});


Route::prefix('admin')->group(function () {
    Route::get('/asd', function () {
        return 'asd';
    });
    Route::get('/fox', function () {
        return 'fox';
    });
});

Route::get('/jobs', [JobsController::class,'index'])->name('Jobsindex');
Route::get('/create', [JobsController::class, 'create'])->name('createjob');
Route::post('/store', [JobsController::class, 'store'])->name('storejob');
Route::get('/edit/{id}', [JobsController::class, 'edit'])->name('editjob');
Route::post('/update/{id}', [JobsController::class, 'update'])->name('updatejob');
Route::get('/delete/{id}', [JobsController::class, 'delete'])->name('deletejob');
Route::post('/ajax_search', [JobsController::class, 'ajax_search'])->name('ajax_search_job');

// Route::get('/', function () {
//     return view('layouts.admin');
// });

Route::get('/asd/{id?}/{name}/{age}', function ($id=null,$name=null,$age) {
    echo('welcome'.$id."to ".$name ." his age is ".$age);
});

// Route::get('users/{id}', [UserController::class, 'index'])->name('user.index');
// Route::controller(OrderController::class)->group(function () {
//     Route::get('/show', 'show');
//     Route::post('/create', 'create');
// });
// Route::get('users/{id}', [UserController::class, 'create'])->name('user.index');

Route::get('/index',[PhotoController::class,'index']);

Route::match(['get','Post'], '/asd', function () {
    return 'get and post are matched';
});

Route::get('/asd', function () {
    return [Home::class,'index'];
});
// this Route::any mean in any method routing is working 
Route::any('/sss', function () {
    return 'welcome any ';
});
// but if there spicfic method that is awlwiyeh ala any
Route::get('/sss', function () {
    return 'welcome get ignor any ';
});

Route::get('/anamosh', function () {
    return 'anan moash ';
});
Route::redirect('/asd', '/anamosh', );


Route::get('/vw', function () {
    return view('welcome');
});


Route::get('/ali', function () {
    return "hellow ali ";
})->name('callali');
Route::get('/qw/{name?}/{age?}', function ($name='ali',$age='59') {
    return $name ." his age is ". $age;
})->where('name','.*');



Route::get('/home', function () {
    return "home";
})->name('home')->middleware('policeman');

Route::get('/admin', function () {
    return "admin";
})->name('admin');


Route::get('/user', function () {
    return "user";
})->name('user');
