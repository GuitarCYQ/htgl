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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){
    Route::get('login','LoginController@index')->name('admin.login');
    Route::post('login','LoginController@login')->name('admin.login');
    Route::post('logout','LoginController@logout')->name('admin.logout');
});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function (){
    Route::get('index','IndexController@index')->name('admin.index');
    Route::get('welcome','IndexController@welcome')->name('admin.welcome');

    //用户
    Route::resource('users', 'UserController',['as' =>  'admin']);
});



