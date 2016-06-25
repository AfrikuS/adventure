<?php

namespace App\Http\Middleware\Work;

use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\Team\WorkerRepository;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class WorkerBelongTeam
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
        if (($team_id = $request->route()->parameter('id')) || ($team_id = $request->get('privateteam_id'))) {

            $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);
            $worker = WorkerRepository::findById(\Auth::id());

            if (WorkerRepository::belongToTeam($worker, $team)) {
                return $next($request);
            }
        }

        Session::flash('message', 'It\'s not your private-team!');
        return Redirect::route('work_privateteams_page');
    }
}
