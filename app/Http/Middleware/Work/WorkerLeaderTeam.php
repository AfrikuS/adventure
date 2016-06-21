<?php

namespace App\Http\Middleware\Work;

use App\Models\Work\Team\PrivateTeam;
use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class WorkerLeaderTeam
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
        if ($team_id = $request->get('privateteam_id')) {

//            $user = \Auth::user();
            $worker = TeamWorkerRepository::findById(\Auth::id());
            $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);

            if ($worker && $team && $team->leader_worker_id == $worker->id) {
                return $next($request);
            }
        }

        Session::flash('message', 'It\'s action ONLY for team-leader!');
        return Redirect::route('work_show_privateteam_page', ['id' => $team_id]);
    }
}
