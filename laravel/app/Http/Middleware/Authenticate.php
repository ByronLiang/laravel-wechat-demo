<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  boolean|null $exception_get_method
     * @return mixed
     */
    public function handle($request, Closure $next, $exception_get_method = false)
    {
        if (($request->method() == 'GET' && $exception_get_method) || Auth::check()) {
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return abort(401, 'Unauthorized.');
        }

        if (Auth::getDefaultDriver() == 'admin') {
            return redirect()->action('Admin\AuthController@getLogin');
        }

        return $next($request);
    }
}
