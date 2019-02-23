<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->role == "admin") return redirect('/super-admin/dashboard');
            if(Auth::user()->role == "teacher") return redirect('/teacher/dashboard');
            if(Auth::user()->role == "parent") return redirect('/parent/dashboard');
        }

        return $next($request);

    }
}
