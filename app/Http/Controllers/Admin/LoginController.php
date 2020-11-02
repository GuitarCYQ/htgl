<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class LoginController extends Controller
{


    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
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
            session()->put('user',$request->except('_token'));
            return redirect()->route('admin.index')->with('success','登陆成功');
        }else
        {
            return redirect()->back()->withErrors(['errors' => '登陆失败']);
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }
}
