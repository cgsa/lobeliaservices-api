<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        $time = time() + 60 * 60 * 24; //One day
        $res = $next($request);
        return $res->cookie('cookie_name', $cookieValue, $time, "/");
        
        if($request->hasCookie('api-cookie'))
        {
            return $next($request);
        }
        
        return redirect('/');
        
    }
}
