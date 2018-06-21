<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //渲染登录页面
    public function create()
    {
        return view('sessions.create');
    }

    //登录
    public function store(Request $request)
    {
        //验证信息
        $credentials = $this->validate($request,[
           'email' => 'required|email|max:255',
           'password' => 'required',
        ]);

        //判断是否登录成功
        if (Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','欢迎回来～！');
            return redirect()->route('users.show',[Auth::user()]);
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    //退出登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您成功退出~!');
        return redirect('login');
    }
}
