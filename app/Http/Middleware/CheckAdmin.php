<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Illuminate\Auth\Access\AuthorizationException;

class CheckAdmin
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
        $token = $request->header('token');
        $passport = Cache::get($token);
        if(!$passport){
            throw new AuthorizationException();
        }
        Cache::put($token, $passport, 120);
        return $next($request);
    }
}
