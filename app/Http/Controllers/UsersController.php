<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\validate;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // 用户首页
    public function index()
    {

    }

    // 用户个人页面
    public function show(User $user)
    {
    	return view('users.show', compact('user'));
    }

    // 用户注册页面
    public function create()
    {
    	return view('users.create');
    }

    // 用户注册
    public function store()
    {
    	$this->validate(request(), [
    		'name' => 'required|max:50',
	        'email' => 'required|email|unique:users|max:255',
	        'password' => 'required|confirmed|min:6' 
    	]);

    	$user = User::create([
    		'name' => request()->name,
    		'email' => request()->email,
    		'password' => bcrypt(request()->password)
    	]);

    	session()->flash('success', '注册成功');

    	return redirect()->route('users.show', [$user]);
    }
}
