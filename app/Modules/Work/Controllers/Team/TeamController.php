<?php

namespace App\Modules\Work\Controllers\Team;

use App\Commands\Work\Team\OfferJoinToTeamCommand;
use App\Exceptions\WorkerBelongTeamException;
use App\Http\Requests;
use App\Models\Work\Worker;
use App\Modules\Work\Controllers\WorkController;
use App\Modules\Work\Persistence\Repositories\Team\TeamRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TeamController extends WorkController
{
    /** @var  TeamRepo */
    protected $teamsRepo;

    /** @var WorkerRepo */
    protected $workerRepo;

    public function __construct(TeamRepo $teams, WorkerRepo $workers)
    {
        parent::__construct();
        
        $this->teamsRepo = $teams;
        $this->workerRepo = $workers;
    }

    public function index($team_id)
    {
//        $privateteam = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);
        $privateteam = $this->teamsRepo->find($team_id);

        $worker = $this->workerRepo->findSimpleWorker($this->user_id);

        // todo redo status field for worker
        if ($worker->id == $privateteam->leader_worker_id) {

//            $teamRepo = new PrivateTeamRepository();
            $joinOffers = $this->teamsRepo->getJoinOffersByTeamId($team_id);
            
//            $pies = TeamRewardPie::where('team_id', $team_id)->get();
            $pies = $this->teamsRepo->getRewardPies($team_id);

            return $this->view('work.team.show.leader', [
                'privateteam' => $privateteam,
                'joinOffers' => $joinOffers,
                'pies' => $pies,
            ]);
        }
        elseif ($worker->team_id == $privateteam->id) {

            return $this->view('work.team.show.partner', [
                'privateteam' => $privateteam,
            ]);
        }
        else {
            return $this->view('work.team.show.guest', [
                'privateteam' => $privateteam,
            ]);
        }

    }
    

    public function offerJoin()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];

        try {
            
            $cmd = new OfferJoinToTeamCommand();

            $cmd->createOfferJoin($this->worker, $team_id);
        }
        
        catch (WorkerBelongTeamException $e) {

            Session::flash('message', 'You are belong to team yet !');
            return Redirect::back();
        }
        
        Session::flash('message', 'Offer was sended!');
        return Redirect::back();
    }

}
