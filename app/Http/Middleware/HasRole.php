<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前请求的路由 对应的控制器方法名
        $route = \Route::current()->getActionName();
//        dd($route);

        //获取当前用户的权限组
        $admin = Admin::find(session()->get('admin')->id);
        //获取当前管理员的角色
        $roles = $admin->role;

        //根据管理员拥有的角色找对应的权限
        //arr 存放权限对应的per_url
        $arr = [];
        foreach ($roles as $v)
        {
            $perms = $v->permission;
            foreach ($perms as $perm)
            {
                $arr[] = $perm->per_url;
            }
        }

        //去除重复的权限
        $arr = array_unique($arr);

        //判断当前请求的路由 在当前管理员的权限里拥有的路由是否一致
        if (in_array($route,$arr)){
            return $next($request);
        }else{
            return redirect('noaccess');
        }


    }
}
