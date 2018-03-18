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
