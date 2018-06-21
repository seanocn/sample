<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //过滤未登录用户
    public function __construct()
    {
        $this->middleware('auth',[
           'except' => ['show','create','store','index']
        ]);

        //只让未登录用户访问注册页面
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    //显示首页
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index',compact('users'));
    }

    //创建用户登录页面
    public function create()
    {
        return view('users.create');
    }

    //显示用户个人信息页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * 处理用户提交数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //验证用户信息
        $this->validate($request,[
           'name' => 'required|max:50',
           'email' => 'required|email|unique:users|max:255',
           'password' => 'required|confirmed|min:6'
        ]);

        //保存到数据库
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
    }

    /**
     * 显示用户编辑页面
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /**
     * 更新用户信息操作
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request,[
           'name' => 'required|max:50',
           'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update',$user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success','个人资料更新成功～！');
        return redirect()->route('users.show',$user->id);
    }

    //删除操作
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户');
        return back();
    }
}
