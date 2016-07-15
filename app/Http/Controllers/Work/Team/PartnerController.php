<?php

namespace App\Http\Controllers\Work\Team;

use App\Entities\Work\Team\TeamWorker;
use App\Http\Controllers\Work\WorkController;
use App\Repositories\Work\PrivateTeamRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class PartnerController extends WorkController
{

    public function leavePrivateTeam()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];
        $worker_id = \Auth::id();

//        $worker = WorkerRepository::findById($worker_id);
        $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);

        if ($this->worker->id == $team->leader_worker_id) {
            
            Session::flash('message', 'Leader cannot leave own team!');
            
            return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
        }

        /** @var TeamWorker */
        $teamWorker = $this->workerRepo->getTeamWorkerSimpleById($worker_id);
        $teamWorker->leftTeam();

//        if ($candidate->team_id !== null) {
//
//            throw new WorkerBelongTeamException;
//        }



        \Session::flash('message', 'You are left team ' . $team_id . ' !');
        return \Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }

}
