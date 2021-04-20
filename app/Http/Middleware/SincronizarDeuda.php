<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\ApiHandler\Handler;

class SincronizarDeuda
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
        //var_dump(request('documento'));die;
        $handler = new Handler(request('documento'),false);
        
        if($handler->syncData())
        {
            $handler->build();
        }
        
        return $next($request);
    }
}
