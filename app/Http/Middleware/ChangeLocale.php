<?php

namespace App\Http\Middleware;

use Closure;

class ChangeLocale
{
    public function handle($request, Closure $next)
    {
        //获取请求头中的accept-language，然后设置语言
        $language = $request->header('accept-language');
        if ($language) {
            \App::setLocale($language);
        }

        return $next($request);
    }
}
