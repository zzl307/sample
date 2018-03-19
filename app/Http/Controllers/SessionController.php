<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    // 登录
    public function create()
    {
    	return view('session.create');
    }
}
