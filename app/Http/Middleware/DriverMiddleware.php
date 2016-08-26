<?php

namespace App\Http\Middleware;

use App\Repositories\Drive\DriverRepository;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Session;

class DriverMiddleware
{
    public function handle($request, Closure $next)
    {
        $user_id = \Auth::id();
        
        $driverRepo = new DriverRepository();
        $driver = $driverRepo->findById($user_id);
        
        if (null != $driver) {

            return $next($request);
        }
        
        Session::flash('message', 'You are not DRIVER !');
        return Redirect::route('profile_page');
    }
}
