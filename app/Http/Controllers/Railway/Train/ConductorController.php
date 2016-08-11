<?php

namespace App\Http\Controllers\Railway\Train;

use App\Commands\Railway\Conductor\TakeBonusThanksCmd;
use App\Commands\Railway\Conductor\TakeRarelyThingCmd;
use App\Commands\Railway\Conductor\TakeRegularBribeCmd;
use App\Exceptions\NotEnoughResourceException;
use App\Http\Controllers\Railway\RailwayController;
use App\Repositories\Railway\Station\ConductorRepo;
use Illuminate\Support\Facades\Input;

class ConductorController extends RailwayController
{
    /** @var ConductorRepo */
    protected $conductorRepo;

    public function __construct()
    {
        parent::__construct();
        
        $this->conductorRepo = new ConductorRepo;
    }

    public function takeRegularBribe()
    {
        $data = Input::all();
        $conductor_id = $data['conductor_id'];

        try {

            $cmd = new TakeRegularBribeCmd();

            $cmd->takeRegularBribe($this->user_id, $conductor_id);

        }
        catch (NotEnoughResourceException $e)
        {
            \Session::flash('message', 'Not enough gold');
        }

        
        return \Redirect::route('railway_train_conductor_page');
    }

    public function takeBonusThanksBribe()
    {
        $data = Input::all();
        $conductor_id = $data['conductor_id'];

        try {

            $cmd = new TakeBonusThanksCmd();

        $cmd->takeBonusThanks($this->user_id, $conductor_id);
        }
        catch (NotEnoughResourceException $e)
        {
            \Session::flash('message', 'Not enough gold');
        }
        


return \Redirect::route('railway_train_conductor_page');
    }

    public function takeRarelyThing()
    {
        $data = Input::all();
        $conductor_id = $data['conductor_id'];

        try {

            $cmd = new TakeRarelyThingCmd();

            $cmd->takeRarelyThing($this->user_id, $conductor_id);

        }
        catch (NotEnoughResourceException $e)
        {
            \Session::flash('message', 'Not enough gold');
        }
    
        
        return \Redirect::route('railway_train_conductor_page');
    }
}
