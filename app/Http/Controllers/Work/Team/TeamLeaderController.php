<?php

namespace App\Http\Controllers\Work\Team;

use App\Commands\Work\Team\Leader\AcceptJoinOfferCommand;
use App\Commands\Work\Team\Leader\RefuseJoinOfferCommand;
use App\Exceptions\WorkerBelongTeamException;
use App\Http\Controllers\Work\AppController;
use App\Repositories\Work\PrivateTeamRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TeamLeaderController extends AppController
{
    public function acceptJoinOffer()
    {
        $data = Input::all();
        $offer_id = $data['offer_id'];

        try {

            $cmd = new AcceptJoinOfferCommand($this->workerRep, new PrivateTeamRepository());

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
}
