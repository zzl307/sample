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

// 用户登录
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');

// 用户退出
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

// 注册认证账号
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// 重置密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 用户创建删除消息
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
