<?php

namespace App\Http\Controllers\Work\Team;

use App\Commands\Work\Team\OfferJoinToTeamCommand;
use App\Commands\Work\Team\UpdateTeamPiesCommand;
use App\Entities\Work\Team\TeamWorker;
use App\Exceptions\WorkerBelongTeamException;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Auth\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamRewardPie;
use App\Models\Work\Worker;
use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\Team\WorkerRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PrivateTeamController extends \App\Http\Controllers\Work\AppController
{
    public function index ()
    {
        $teams = PrivateTeamRepository::getAllTeamsWithWorkers();

/*        $cmd = new UpdateTeamPiesCommand(new PrivateTeamRepository());
        foreach ($teams as $team) {
            $cmd->updateTeamPies($team->id);
        }*/

        return $this->view('work.team.teams_index', [
            'teams' => $teams,
        ]);
    }

    public function showPrivateTeam($id)
    {
        $privateteam = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($id);


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

    public function createPrivateteam()
    {
        return $this->view('work.team.create_privateteam', []);
    }

    public function createPrivateteamAction()
    {
        $leader = WorkerRepository::findById(auth()->id());

        // begin organise teamwork
        $team = PrivateTeamRepository::createPrivateTeamwork($leader);
        PrivateTeamRepository::attachPartnerToTeamwork($leader, $team);

        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }

/*    public function addPartnerToPrivateteamAction()
    {
        $data = Input::all();
        $worker_id = $data['worker_id'];
        $team_id = $data['privateteam_id'];

        $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);
        $worker = WorkerRepository::findById($worker_id); // todo offers from workers

        // todo exclude validate to middleware
        if ($worker && $worker->team_id === null) {

            PrivateTeamRepository::addWorkerToTeam($worker, $team);

            Session::flash('message', 'New parnter was added to privateteam!');
        }
        else {
            Session::flash('message', 'Worker has privateteam yet!');
            return redirect()->back();
        }


        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }*/

    public function deletePrivateteamAction()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];


        PrivateTeamRepository::deleteTeamById($team_id);

        Session::flash('message', 'Team is deleted. Workers are free!');
        return Redirect::route('work_privateteams_page');
    }

    public function leavePrivateTeam()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];
        $worker_id = \Auth::id();

        $worker = WorkerRepository::findById($worker_id);
        $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);

        if ($worker->id == $team->leader_worker_id) {
            Session::flash('message', 'Leader cannot leave own team!');
            return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
        }

        /** @var TeamWorker */
        $teamWorker = $this->workerRep->getTeamWorkerSimpleById($worker_id);
        $teamWorker->leftTeam();

//        if ($candidate->team_id !== null) {
//
//            throw new WorkerBelongTeamException;
//        }



        Session::flash('message', 'You are left team ' . $team_id . ' !');
        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
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

/*    public function commitPrivateteamAction()
    {
        $data = Input::all();

        $team = PrivateTeamRepository::getTeamworkWithCreatorAndPartnersById($data['privateteam_id']);

        if ($team->status === 'committed') {
            Session::flash('message', 'Team is commited yet!');
        }
//        elseif ($this->user_id != $team->creator->id) {
//            Session::flash('message', 'Committ must do by creator team  !');
//        }
        else {
            DB::transaction(function () use ($team) {

                foreach ($team->partners as $partner) {
                    $worker = PrivateTeamRepository::createWorker($partner, $team);
                }

                $team->status = 'committed';
                $team->save();
            });
            Session::flash('message', 'Privateteam was committed !');
        }

        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }
*/

}
