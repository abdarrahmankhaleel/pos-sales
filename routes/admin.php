<?php

use App\Http\Controllers\Admin\AccountTypesController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Sales_matrial_typesController;
use App\Http\Controllers\Admin\TreasuriesController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\Inv_UomController;
use App\Http\Controllers\Admin\Inv_itemcard_categoriesController;
use App\Http\Controllers\Admin\InvItemCardController;

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

define('PADINATION_COUNT',5);
/// middel ware من نوع اث يعني عامل لوقن
// هون كان 'namespace'=>'Admin'   شلناها عشان الامر راوت لست مش شايف الكونرولر الي خليناه رسورس الي هو بتاع جدول فئات الاصناف
Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function () {

    Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('logout',[LoginController::class,'logout'])->name('admin.logout');
    Route::get('/adminpanalsettings/index',[Admin_panel_settingsController::class,'index'])->name('admin.panalsettings.index');
    Route::get('/adminpanalsettings/edit',[Admin_panel_settingsController::class,'edit'])->name('admin.panalsettings.edit');
    Route::post('/adminpanalsettings/update',[Admin_panel_settingsController::class,'update'])->name('admin.panalsettings.update');
    /* stert  treasure */
    Route::get('/treasuries/index', [TreasuriesController::class, 'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/create', [TreasuriesController::class, 'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store', [TreasuriesController::class, 'store'])->name('admin.treasuries.store');
    Route::get('/treasuries/edit/{id}', [TreasuriesController::class, 'edit'])->name('admin.treasuries.edit');
    Route::post('/treasuries/update/{id}', [TreasuriesController::class, 'update'])->name('admin.treasuries.update');
    Route::post('/treasuries/ajax_search', [TreasuriesController::class, 'ajax_search'])->name('admin.treasuries.ajax_search');
    Route::get('/treasuries/details/{id}', [TreasuriesController::class, 'details'])->name('admin.treasuries.details');
    Route::get('/treasuries/Add_treasuries_delivery/{id}', [TreasuriesController::class, 'Add_treasuries_delivery'])->name('admin.treasuries.Add_treasuries_delivery');
    Route::post('/treasuries/store_treasuries_delivery/{id}', [TreasuriesController::class, 'store_treasuries_delivery'])->name('admin.treasuries.store_treasuries_delivery');
    Route::get('/treasuries/delete_treasuries_delivery/{id}', [TreasuriesController::class, 'delete_treasuries_delivery'])->name('admin.treasuries.delete_treasuries_delivery');    

    /* end  treasure */


    /* stert  sales_matrial_types */
    Route::get('/sales_matrial_types/index', [Sales_matrial_typesController::class, 'index'])->name('admin.sales_matrial_types.index');
    Route::get('/sales_matrial_types/create', [Sales_matrial_typesController::class, 'create'])->name('admin.sales_matrial_types.create');
    Route::post('/sales_matrial_types/store', [Sales_matrial_typesController::class, 'store'])->name('admin.sales_matrial_types.store');
    Route::get('/sales_matrial_types/edit/{id}', [Sales_matrial_typesController::class, 'edit'])->name('admin.sales_matrial_types.edit');
    Route::post('/sales_matrial_types/update/{id}', [Sales_matrial_typesController::class, 'update'])->name('admin.sales_matrial_types.update');
    Route::get('/sales_matrial_types/delete/{id}', [Sales_matrial_typesController::class, 'delete'])->name('admin.sales_matrial_types.delete');

    /* end  sales_matrial_types */

    /* stert  stores */
    Route::get('/stores/index', [StoresController::class, 'index'])->name('admin.stores.index');
    Route::get('/stores/create', [StoresController::class, 'create'])->name('admin.stores.create');
    Route::post('/stores/store', [StoresController::class, 'store'])->name('admin.stores.store');
    Route::get('/stores/edit/{id}', [StoresController::class, 'edit'])->name('admin.stores.edit');
    Route::post('/stores/update/{id}', [StoresController::class, 'update'])->name('admin.stores.update');
    Route::get('/stores/delete/{id}', [StoresController::class, 'delete'])->name('admin.stores.delete');

    /* end  stores */

      /*         start  Uoms                */
Route::get('/uoms/index', [Inv_UomController::class, 'index'])->name('admin.uoms.index');
Route::get('/uoms/create', [Inv_UomController::class, 'create'])->name('admin.uoms.create');
Route::post('/uoms/store', [Inv_UomController::class, 'store'])->name('admin.uoms.store');
Route::get('/uoms/edit/{id}', [Inv_UomController::class, 'edit'])->name('admin.uoms.edit');
Route::post('/uoms/update/{id}', [Inv_UomController::class, 'update'])->name('admin.uoms.update');
Route::get('/uoms/delete/{id}', [Inv_UomController::class, 'delete'])->name('admin.uoms.delete');
Route::post('/uoms/ajax_search', [Inv_UomController::class, 'ajax_search'])->name('admin.uoms.ajax_search');
/*           end Uoms                */


    
/*         start  inv_itemcard_categories                */
Route::get('/inv_itemcard_categories/delete/{id}', [Inv_itemcard_categoriesController::class, 'delete'])->name('admin.inv_itemcard_categories.delete');

Route::resource('/inv_itemcard_categories',Inv_itemcard_categoriesController::class);
      

      /*           end inv_itemcard_categories                */

/*         start  Item Card                */
Route::get('/itemcard/index', [InvItemCardController::class, 'index'])->name('admin.itemcard.index');
Route::get('/itemcard/create', [InvItemCardController::class, 'create'])->name('admin.itemcard.create');
Route::post('/itemcard/store', [InvItemCardController::class, 'store'])->name('admin.itemcard.store');
Route::get('/itemcard/edit/{id}', [InvItemCardController::class, 'edit'])->name('admin.itemcard.edit');
Route::post('/itemcard/update/{id}', [InvItemCardController::class, 'update'])->name('admin.itemcard.update');
Route::get('/itemcard/delete/{id}', [InvItemCardController::class, 'delete'])->name('admin.itemcard.delete');
Route::post('/itemcard/ajax_search', [InvItemCardController::class, 'ajax_search'])->name('admin.itemcard.ajax_search');
Route::get('/itemcard/show/{id}', [InvItemCardController::class, 'show'])->name('admin.itemcard.show');
Route::post('/itemcard/ajax_search_movements', [InvItemCardController::class, 'ajax_search_movements'])->name('admin.itemcard.ajax_search_movements');
/*           end Item Card                */


    /* stert  accountTypes */
    Route::get('/accountTypes/index', [AccountTypesController::class, 'index'])->name('admin.accountTypes.index');
    /* end  accountTypes */


    /*         start  accounts              */
Route::get('/accounts/index', [AccountsController::class, 'index'])->name('admin.accounts.index');
Route::get('/accounts/create', [AccountsController::class, 'create'])->name('admin.accounts.create');
Route::post('/accounts/store', [AccountsController::class, 'store'])->name('admin.accounts.store');
Route::get('/accounts/edit/{id}', [AccountsController::class, 'edit'])->name('admin.accounts.edit');
Route::post('/accounts/update/{id}', [AccountsController::class, 'update'])->name('admin.accounts.update');
Route::get('/accounts/delete/{id}', [AccountsController::class, 'delete'])->name('admin.accounts.delete');
Route::post('/accounts/ajax_search', [AccountsController::class, 'ajax_search'])->name('admin.accounts.ajax_search');
Route::get('/accounts/show/{id}', [AccountsController::class, 'show'])->name('admin.accounts.show');
Route::post('/accounts/ajax_search_movements', [AccountsController::class, 'ajax_search_movements'])->name('admin.accounts.ajax_search_movements');
/*           end accounts           */

    /*         start  customers              */
    Route::get('/customers/index', [CustomersController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/create', [CustomersController::class, 'create'])->name('admin.customers.create');
    Route::post('/customers/store', [CustomersController::class, 'store'])->name('admin.customers.store');
    Route::get('/customers/edit/{id}', [CustomersController::class, 'edit'])->name('admin.customers.edit');
    Route::post('/customers/update/{id}', [CustomersController::class, 'update'])->name('admin.customers.update');
    Route::get('/customers/delete/{id}', [CustomersController::class, 'delete'])->name('admin.customers.delete');
    Route::post('/customers/ajax_search', [CustomersController::class, 'ajax_search'])->name('admin.customers.ajax_search');
    Route::get('/customers/show/{id}', [CustomersController::class, 'show'])->name('admin.customers.show');
    Route::post('/customers/ajax_search_movements', [CustomersController::class, 'ajax_search_movements'])->name('admin.customers.ajax_search_movements');
    /*           end customers           */

});


///هنا من نوع قست يعني مش عامل لوقن
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'guest:admin'],function () {
    Route::get('login',[LoginController::class,'show_login_view'])->name('admin.showlogin');
    Route::post('login',[LoginController::class,'login'])->name('admin.login');
});






