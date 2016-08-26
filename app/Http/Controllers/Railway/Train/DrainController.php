<?php

namespace App\Http\Controllers\Railway\Train;

use App\Commands\Railway\Train\DrainOilCmd;
use App\Commands\Railway\Train\DrainPetrolCmd;
use App\Entities\Hero\HeroEntity;
use App\Exceptions\NotEnoughResourceException;
use App\Models\Core\Hero;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class DrainController extends MeetingController
{
    public function oil()
    {
        $data = Input::all();
        $amount = $data['amount'];
        $price = $data['price'];
        $train_id = $data['train_id'];

        try {

            $cmd = new DrainOilCmd($this->heroRepo);

            $cmd->drainOil($this->user_id, $amount, $price);

        }
        catch (NotEnoughResourceException $e)
        {
//            return redirect('dashboard')->with('status', 'Profile updated!');
            Session::flash('message', 'Not enough gold');
        }

        return \Redirect::route('railway_train_conductor_page');
    }

    public function petrol()
    {
        $data = Input::all();
        $amount = $data['amount'];
        $price = $data['price'];
        $train_id = $data['train_id'];

        try {

            $cmd = new DrainPetrolCmd($this->heroRepo);

            $cmd->drainPetrol($this->user_id, $amount, $price);

        }
        catch (NotEnoughResourceException $e) 
        {
            Session::flash('message', 'Not enough gold');
        }

        return \Redirect::route('railway_train_conductor_page');
    }
}
