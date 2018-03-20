<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    // 用户创建消息
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'content' => 'required|max:140'
    	]);

    	\Auth::user()->status()->create([
    		'content' => $request['content']
    	]);

        session()->flash('success', '发布成功');

    	return redirect()->back();
    }

    // 用户删除消息
    public function destroy(Status $status)
    {   
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '删除成功');

        return redirect()->back();
    }
}
