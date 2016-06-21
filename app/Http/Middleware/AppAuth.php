<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Torann\Registry\Facades\Registry;

class AppAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            return $next($request);
        }

        return redirect('/sign_in');
    }
}
