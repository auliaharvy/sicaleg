<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'Auth\LoginController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('chart', 'API\DashboardController@chart');
    Route::get('/chart2', 'API\DashboardDuaController@chart');
    Route::get('chart-desa', 'API\DashboardController@chartDesa');
    Route::get('export', 'API\DashboardController@exportData');
    Route::resource('/outlets', 'API\OutletController')->except(['show']);
    Route::resource('/kecamatans', 'API\MstKecamatanController')->except(['show']);
    Route::resource('/desas', 'API\MstDesaController')->except(['show']);
    Route::resource('/dpt', 'API\MstDptController')->except(['show']);
    Route::get('/name-desa', 'API\MstDesaController@getNameDesa');
    Route::resource('/konstituens', 'API\TrxKonstituenController')->except(['show', 'show', 'update']);
    Route::post('/konstituens/{id}', 'API\TrxKonstituenController@update')->name('konstituen.update');
    Route::resource('/c1', 'API\MstCSatuController')->except(['show', 'show', 'update']);
    Route::post('/c1/{id}', 'API\MstCSatuController@update')->name('cSatu.update');
    // Route::resource('/tps', 'API\MstTpsController')->except(['show']);
    Route::resource('tps', 'API\MstTpsController')->except(['create', 'show']);
    Route::get('/tps/{id}/edit/chart', 'API\MstTpsController@chart');
    
    Route::resource('/couriers', 'API\UserController')->except(['create', 'show', 'update']);
    Route::post('/couriers/{id}', 'API\UserController@update')->name('couriers.update');
    Route::get('/rekruter', 'API\UserController@rekruter');

    Route::resource('product', 'API\ProductController')->except(['create', 'show']);
    Route::get('/product/laundry-type', 'API\ProductController@getLaundryType');
    Route::post('/product/laundry-type', 'API\ProductController@storeLaundryType');

    Route::get('user-authenticated', 'API\UserController@getUserLogin')->name('user.authenticated');
    Route::get('user-lists', 'API\UserController@userLists')->name('user.index');
    Route::get('roles', 'API\RolePermissionController@getAllRole')->name('roles');
    Route::get('permissions', 'API\RolePermissionController@getAllPermission')->name('permission');
    Route::post('role-permission', 'API\RolePermissionController@getRolePermission')->name('role_permission');
    Route::post('set-role-permission', 'API\RolePermissionController@setRolePermission')->name('set_role_permission');
    Route::post('set-role-user', 'API\RolePermissionController@setRoleUser')->name('user.set_role');

    Route::resource('expenses', 'API\ExpensesController')->except(['create', 'show']);
    Route::post('expenses/accept', 'API\ExpensesController@accept')->name('expenses.accept');
    Route::post('expenses/cancel', 'API\ExpensesController@cancelRequest')->name('expenses.cancel');
    Route::resource('notification', 'API\NotificationController')->except(['create', 'destroy']);

    Route::resource('customer', 'API\CustomerController')->except(['create', 'show']);
    Route::resource('transaction', 'API\TransactionController')->except(['create', 'show']);
    Route::post('transaction/payment', 'API\TransactionController@makePayment');
    Route::post('transaction/complete-item', 'API\TransactionController@completeItem');
});