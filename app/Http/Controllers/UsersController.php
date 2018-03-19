<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\validate;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    // 用户首页
    public function index()
    {   
        $users = User::paginate(16);

        return view('users.index', compact('users'));
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

        \Auth::login($user);
    	session()->flash('success', '注册成功');

    	return redirect()->route('users.show', [$user]);
    }

    // 用户修改页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    // 用户修改
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '修改成功');

        return redirect()->route('users.show', $user->id);
    }

    // 用户删除
    public function destroy(User $user)
    {   
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '删除成功');

        return redirect()->back();
    }
}
