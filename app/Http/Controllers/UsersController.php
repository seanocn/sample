<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //渲染登录页面
    public function create()
    {
        return view('users.create');
    }
}
