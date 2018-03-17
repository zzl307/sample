<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    // 测试页面
    public function index()
    {
    	return view('static.index');
    }
}
