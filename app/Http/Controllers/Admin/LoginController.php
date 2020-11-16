<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class LoginController extends Controller
{


    protected $redirectTo = '/admin/index';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        if ($this->guard()->check()){
            return redirect()->route('admin.index');
        }
    }

    //使用auth.php的guard->admin
    public function guard()
    {
        return auth()->guard('admin');
    }

    public function index()
    {

        return view('admin.login.index');
    }

    public function login(LoginRequest $request)
    {

        if ($this->guard()->attempt($request->only(['username','password']))){
            $admin = Admin::where('username',$request['username'])->first();
            session()->put('admin',$admin);
            return redirect()->route('admin.index')->with('success','欢迎回来！');
        }else
        {
            return redirect()->back()->withErrors(['errors' => '登陆失败']);
        }
    }

    //用户退出
    public function logout()
    {
        $this->guard()->logout();
        return redirect(route('admin.login'));
    }

    //无权限
    public function noaccess()
    {
        return view('shared.noaccess');
    }
}
