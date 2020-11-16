<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//后台登录
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){

    Route::get('login','LoginController@index')->name('admin.login');

    Route::post('login','LoginController@login')->name('admin.login');

    Route::get('logout','LoginController@logout')->name('admin.logout');
});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['AdminCheck']],function (){
    Route::get('index','IndexController@index')->name('admin.index');
    Route::get('welcome','IndexController@welcome')->name('admin.welcome');

    //用户
    Route::post('users/delAll','UserController@delAll')->name('users.delAll');
    Route::resource('users', 'UserController',['as' => 'admin'])->except('show');

    //管理员
    Route::get('admin/auth/{id}','AdminController@auth')->name('admin.admin.auth');
    Route::post('admin/doAuth','AdminController@doAuth')->name('admin.admin.doAuth');
    Route::resource('admin','AdminController',['as' => 'admin']);

    //角色
    Route::get('role/auth/{id}','RoleController@auth')->name('admin.role.auth');
    Route::post('role/doAuth','RoleController@doAuth')->name('admin.role.doAuth');
    Route::resource('role','RoleController',['as' => 'admin']);

    //权限
    Route::resource('permission','PermissionController',['as' => 'admin']);
});

Route::get('noaccess','Admin\LoginController@noaccess');


