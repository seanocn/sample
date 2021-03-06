<?php

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

Route::get('/', 'StaticPagesController@home')->name('home'); //显示首页
Route::get('/about', 'StaticPagesController@about')->name('about'); //显示关于页面
Route::get('/help', 'StaticPagesController@help')->name('help'); //显示帮助页面

Route::get('signup','UsersController@create')->name('signup'); //显示注册页面
Route::resource('users','UsersController'); //用户资源路由

Route::get('login','SessionsController@create')->name('login'); //显示登录页面
Route::post('login','SessionsController@store')->name('login'); //登录
Route::delete('logout','SessionsController@destroy')->name('logout'); //退出登录