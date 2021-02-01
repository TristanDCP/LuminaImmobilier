<?php

namespace App\Http\Middleware;

use Closure;

class AdminRoutes
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
    } else {
        return response()->json(['message' => "Vous n'êtes pas autorisé à visualiser cette page."], 401);
    }
}
}
