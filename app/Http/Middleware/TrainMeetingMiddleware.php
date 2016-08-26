<?php

namespace App\Http\Middleware;

use App\Models\Npc\ConductorSession;
use Closure;

class TrainMeetingMiddleware
{
    public function handle($request, Closure $next)
    {
        $user_id = \Auth::id();

        if (! ConductorSession::where('hero_id', $user_id)->exists()) {

            return \Redirect::route('railway_trains_page');
        }

        return $next($request);
    }
}
