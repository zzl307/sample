<?php

namespace App\Http\Controllers;

use Illuminate\Auth\validate;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    // 用户登录
    public function create()
    {
    	return view('sessions.create');
    } 

    // 用户登录验证
    public function store(Request $request)
    {
    	$credentials = $this->validate($request, [
    		'email' => 'required|email|max:255',
           	'password' => 'required'
    	]);

    	if (\Auth::attempt($credentials, $request->has('remember'))) {
    		session()->flash('success', '登录成功');

    		return redirect()->route('users.show', [\Auth::user()]);
    	} else {
    		session()->flash('danger', '很抱歉， 邮箱或密码不匹配');

    		return redirect()->back();
    	}
    }

    // 用户退出
    public function destroy()
    {
    	\Auth::logout();
    	session()->flash('success', '退出成功');
    	return redirect()->route('login');
    }
}
