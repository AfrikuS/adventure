<?php

namespace App\Http\Controllers\Work;

use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\Team\WorkerRepository;

class TeamsController extends WorkController
{
    public function index()
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

    public function createPrivateteam()
    {
        return $this->view('work.team.create_privateteam', []);
    }


    public function createTeam()
    {
        $leader = WorkerRepository::findById(auth()->id());

        // begin organise teamwork
        $team = PrivateTeamRepository::createPrivateTeamwork($leader);
        PrivateTeamRepository::attachPartnerToTeamwork($leader, $team);

        return \Redirect::route('work_show_privateteam_page', ['id' => $team->id]);
    }

}
