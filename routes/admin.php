<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BranchController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Permission\Models\Permission;
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

define('PAGINATION_COUNT',11);
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

 Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function(){
 Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
 Route::get('logout',[LoginController::class,'logout'])->name('admin.logout');



/*         start  customer                */
Route::get('/customer/index',[CustomerController::class,'index'])->name('admin.customer.index');
Route::get('/customer/create',[CustomerController::class,'create'])->name('admin.customer.create');
Route::post('/customer/store',[CustomerController::class,'store'])->name('admin.customer.store');
Route::get('/customer/show/{id}',[CustomerController::class,'show'])->name('admin.customer.show');
Route::get('/customer/edit/{id}',[CustomerController::class,'edit'])->name('admin.customer.edit');
Route::post('/customer/update/{id}',[CustomerController::class,'update'])->name('admin.customer.update');
Route::get('/customer/delete/{id}',[CustomerController::class,'delete'])->name('admin.customer.delete');
Route::post('/customer/ajax_search',[CustomerController::class,'ajax_search'])->name('admin.customer.ajax_search');
Route::get('/customer/export', [CustomerController::class,'export'])->name('admin.customer.export');
/*         end  customer                */



/*         start  update login admin                 */
Route::get('/admin/edit/{id}',[LoginController::class,'editlogin'])->name('admin.login.edit');
Route::post('/admin/update/{id}',[LoginController::class,'updatelogin'])->name('admin.login.update');
/*         end  update login admin                */

/// Role and permission
Route::resource('employee', 'App\Http\Controllers\Admin\EmployeeController',[ 'as' => 'admin']);
Route::get('role', 'App\Http\Controllers\Admin\RoleController@index')->name('admin.role.index');
Route::get('role/create', 'App\Http\Controllers\Admin\RoleController@create')->name('admin.role.create');
Route::get('role/{id}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->name('admin.role.edit');
Route::patch('role/{id}', 'App\Http\Controllers\Admin\RoleController@update')->name('admin.role.update');
Route::post('role', 'App\Http\Controllers\Admin\RoleController@store')->name('admin.role.store');
Route::post('admin/role/delete', 'App\Http\Controllers\Admin\RoleController@delete')->name('admin.role.delete');

Route::get('/permissions/{guard_name}', function($guard_name){
    return response()->json(Permission::where('guard_name',$guard_name)->get());
});


// Notification
Route::get('/notifications/create',[NotificationController::class,'create'])->name('notifications.create');
Route::post('/notifications/send',[NotificationController::class,'send'])->name('notifications.send');



// Resource Route
Route::resource('categories', CategoryController::class);
Route::resource('units', UnitController::class);
Route::resource('products', ProductController::class);
Route::resource('productReviews', ProductReviewController::class);
Route::resource('offers', OfferController::class);
Route::resource('orders', OrderController::class);
Route::resource('banners', BannerController::class);
Route::resource('coupons', CouponController::class);
Route::resource('deliveries', DeliveryController::class);
Route::resource('settings', SettingController::class);
Route::resource('branches', BranchController::class);



});


});



Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'guest:admin'],function(){
    Route::get('login',[LoginController::class,'show_login_view'])->name('admin.showlogin');
    Route::post('login',[LoginController::class,'login'])->name('admin.login');

});







