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

// Route::get('/', function () {
//     return view('index');
// });
// 

Route::get('/', 'StaticPagesController@index');

// 测试页面
Route::get('/index', 'StaticPagesController@index');

// 显示用户的信息
Route::resource('users', 'UsersController');

<<<<<<< HEAD
// 登录
Route::get('login', 'SessionController@create')->name('login');
Route::post('login', 'SessionController@store')->name('login');

// 退出
Route::delete('logout', 'SessionController@destroy')->name('logout');
=======
// 用户登录
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');

// 用户退出
Route::delete('logout', 'SessionsController@destroy')->name('logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 注册认证账号
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
>>>>>>> ac97fc0cf9066a7528f478f912053e06a9f98e9d
