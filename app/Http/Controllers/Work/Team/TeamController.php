<?php

namespace App\Http\Controllers\Work\Team;

use App\Commands\Work\Team\OfferJoinToTeamCommand;
use App\Commands\Work\Team\UpdateTeamPiesCommand;
use App\Entities\Work\Team\TeamWorker;
use App\Exceptions\WorkerBelongTeamException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Work\WorkController;
use App\Http\Requests;
use App\Models\Auth\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamRewardPie;
use App\Models\Work\Worker;
use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TeamController extends WorkController
{
    /** @var  PrivateTeamRepository */
    protected $teamRepo;

    public function __construct(PrivateTeamRepository $teamRepo, WorkerRepositoryObj $workerRepo)
    {
        parent::__construct($workerRepo);
        
        $this->teamRepo = $teamRepo;
    }

    public function index($id)
    {
        $privateteam = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($id);

        // todo redo status field for worker
        if ($this->worker->id == $privateteam->leader_worker_id) {

            $teamRepo = new PrivateTeamRepository();
            $joinOffers = $teamRepo->getJoinOffersByTeamId($id);
            
            $pies = TeamRewardPie::where('team_id', $id)->get();

            return $this->view('work.team.show.leader', [
                'privateteam' => $privateteam,
                'joinOffers' => $joinOffers,
                'pies' => $pies,
            ]);
        }
        elseif ($this->worker->team_id == $privateteam->id) {

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
