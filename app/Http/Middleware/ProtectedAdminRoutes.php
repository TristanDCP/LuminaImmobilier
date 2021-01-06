<?php

namespace App\Http\Middleware;

use Closure;

class ProtectedAdminRoutes
{
   

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    if (auth()->user()->idRole != 1) {
       return $next($request);
    }

    abort(401);
}
}
