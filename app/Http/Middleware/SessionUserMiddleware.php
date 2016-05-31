<?php

namespace App\Http\Middleware;

use Closure;

class SessionUserMiddleware
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
        // 请求前中间件
        
        return $next($request);
    }
}
