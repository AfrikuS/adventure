<?php

namespace App\Http\Middleware\Work;

use App\Repositories\Work\Team\WorkerRepository;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class WorkerLeaderOnlyOneTeam
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
        $user = \Auth::user();
        $worker = WorkerRepository::findById($user->id);
//        $hasTeam = $worker->team->select('id')->get()->first(); // hasTeam todo ?
        $hasTeamYet = $worker->team !== null;

        if ($hasTeamYet) {
            Session::flash('message', 'Worker must have only one private-team!');
            return Redirect::route('work_privateteams_page');
        }

        return $next($request);
    }
}
