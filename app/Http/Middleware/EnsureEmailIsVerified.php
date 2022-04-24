<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //三个判断：
        //1.如果用户已经登陆
        //2.并且还未认证Email
        //3.并且访问的不是email验证相关URL或者退出的URL
        if($request->user() &&
        ! $request->user()->hasVerifiedEmail() &&
        ! $request->is('email/*','logout')){

            //根据客户端返回对应的内容
            return $request->expectsJson()
                        ? abort(403, '你的邮箱地址未验证。')
                        : redirect()->route('verification.notice');
        }


        return $next($request);
    }
}
