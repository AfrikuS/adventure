<?php

namespace App\Http\Controllers\Work\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamWorker;
use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use App\Transactions\Work\Team\PrivateTeamTransactions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PrivateTeamController extends Controller
{
    public function index ()
    {
        $teams = PrivateTeamRepository::getAllTeamsWithWorkers();

        return $this->view('work/team/teams_index', [
            'teams' => $teams,
        ]);
    }

    public function showPrivateTeam($id)
    {
        $privateteam = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($id);

        return $this->view('work/team/show_privateteam', [
            'privateteam' => $privateteam,
        ]);
    }

    public function createPrivateteam()
    {
        return $this->view('work/team/create_privateteam', []);
    }

    public function createPrivateteamAction()
    {
        $leader = TeamWorkerRepository::findById(auth()->id());

        // begin organise teamwork
        $team = PrivateTeamRepository::createPrivateTeamwork($leader);
        PrivateTeamRepository::attachPartnerToTeamwork($leader, $team);

        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }

    public function addPartnerToPrivateteamAction()
    {
        $data = Input::all();
        $worker_id = $data['worker_id'];
        $team_id = $data['privateteam_id'];

        $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);
        $worker = TeamWorkerRepository::findById($worker_id); // todo offers from workers

        // todo exclude validate to middleware
        if ($worker && TeamWorkerRepository::workerHaveNotTeam($worker)) {

            PrivateTeamTransactions::addWorkerToTeam($worker, $team);

            Session::flash('message', 'New parnter was added to privateteam!');
        }
        else {
            Session::flash('message', 'Worker has privateteam yet!');
            return redirect()->back();
        }


        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }

    public function deletePrivateteamAction()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];


        PrivateTeamTransactions::deleteTeamById($team_id);

        Session::flash('message', 'Team is deleted. Workers are free!');
        return Redirect::route('work_privateteams_page');
    }

    public function leavePrivateTeam()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];

//        $name = \Auth::getName();

        $worker = TeamWorkerRepository::findById(\Auth::id());
        $team = PrivateTeamRepository::getTeamWithCreatorAndPartnersById($team_id);

        if ($worker->id == $team->leader->id) {
            Session::flash('message', 'Leader cannot leave own team!');
            return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
        }

        PrivateTeamTransactions::excludeWorkerFromTeam($worker, $team);

        Session::flash('message', 'You are left team ' . $team_id . ' !');
        return Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
//        return Redirect::route('work_privateteams_page');


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
                    $worker = PrivateTeamRepository::createTeamWorker($partner, $team);
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
