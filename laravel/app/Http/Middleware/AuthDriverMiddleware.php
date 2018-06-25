<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthDriverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard) {
            Auth::setDefaultDriver($guard);
        }

        return $next($request);
    }
}
