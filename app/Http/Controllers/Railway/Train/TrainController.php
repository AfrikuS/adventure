<?php

namespace App\Http\Controllers\Railway\Train;

use App\Commands\Railway\Train\DepartTrainCmd;
use App\Commands\Railway\Train\FinishConductorSessionCmd;
use App\Http\Controllers\Railway\RailwayController;
use App\Repositories\Railway\Station\ConductorRepo;
use App\Repositories\Railway\TrainRepo;
use Illuminate\Support\Facades\Redirect;

class TrainController extends RailwayController
{
    public function index()
    {

        $conductorRepo = new ConductorRepo();
        $trainRepo = new TrainRepo();

        $meeting = $conductorRepo->findMeetingByHeroId($this->user_id);

//        $train = $tr/ainRepo->finById($meeting->train_id);


        return $this->view('railway.train.index', [
            'meeting' => $meeting,
        ]);
    }

    public function depart()
    {
        
        $cmd = new DepartTrainCmd();

        $cmd->departTrain($this->user_id);

        
        
        return Redirect::route('railway_trains_page');
    }

    protected function view($view = null, $data = [])
    {
        
        
        
//        $data['train'] = (object) $this->worker->toArray();

        return parent::view($view, $data);
    }
}
