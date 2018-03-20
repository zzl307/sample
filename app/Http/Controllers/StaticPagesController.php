<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    // 测试页面
    public function index()
    {	
    	$feed_items = [];
    	// dd(\Auth::user()->feed());
    	if (\Auth::check()) {
    		$feed_items = \Auth::user()->feed()->paginate(16);
    	}

    	return view('static.index', compact('feed_items'));
    }
}
