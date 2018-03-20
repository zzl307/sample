<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\validate;
use Illuminate\Http\Request;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
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
        $statuses = $user->status()
                            ->orderBy('created_at', 'desc')
                            ->paginate(16);

    	return view('users.show', compact('user', 'statuses'));
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

        $this->sendEmailConfirmationTo($user);
    	session()->flash('success', '验证码已经发到你的邮件，请去验证');

    	return redirect('/');
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

    // 用户注册验证
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        \Auth::login($user);
        session()->flash('success', '用户注册验证成功');
        return redirect()->route('users.show', [$user]);
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'zb@exands.com';
        $name = 'zb';
        $to = $user->email;
        $subject = '感谢你注册本应用';

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    // 关注用户
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(16);
        $title = '关注的人';

        return view('users.show_follow', compact('users', 'title'));
    }

    // 粉丝用户
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(16);
        $title = '我的粉丝';

        return view('users.show_follow', compact('users', 'title'));
    }
}
