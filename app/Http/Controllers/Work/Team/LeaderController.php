<?php

namespace App\Http\Controllers\Work\Team;

use App\Commands\Work\Team\Leader\AcceptJoinOfferCommand;
use App\Commands\Work\Team\Leader\RefuseJoinOfferCommand;
use App\Exceptions\WorkerBelongTeamException;
use App\Http\Controllers\Work\WorkController;
use App\Repositories\Work\PrivateTeamRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LeaderController extends WorkController
{
    public function acceptJoinOffer()
    {
        $data = Input::all();
        $offer_id = $data['offer_id'];

        try {

            $cmd = new AcceptJoinOfferCommand($this->workerRepo, new PrivateTeamRepository());

            $cmd->acceptWorkerToTeam($offer_id);
        }
        
        catch (WorkerBelongTeamException $e) {

            Session::flash('message', 'This worker is belong to other team yet !');
            return Redirect::back();
        }

        Session::flash('message', 'Worker accepted to your team!');
        return Redirect::back();
    }
    
    public function refuseJoinOffer()
    {
        $data = Input::all();
        $offer_id = $data['offer_id'];

        $cmd = new RefuseJoinOfferCommand(new PrivateTeamRepository());

        $cmd->refuseJoinOffer($offer_id);


        Session::flash('message', 'Offer by worker was refused !');
        return Redirect::back();
    }

    public function deleteTeam()
    {
        $data = Input::all();
        $team_id = $data['privateteam_id'];


        PrivateTeamRepository::deleteTeamById($team_id);

        Session::flash('message', 'Team is deleted. Workers are free!');
        return Redirect::route('work_privateteams_page');
    }

}
