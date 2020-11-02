<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //当auth中间件判定某个用户未认证 会返回一个JSON 401 相响应 或者 如果不是AJAX 请求的话， 将用户重定向到login命名路由 也就是登录页面
//        if (Auth::guard($guard)->guest()){
//            if ($request->ajax() || $request->wantsJson()) {
//                return response('Unauthorized.', 401);
//            }else {
//                return redirect()->guest('admin/login');
//            }
//        }
        return $next($request);
    }
}
