<?php

namespace App\Http\Controllers\Mine;

use App\Http\Controllers\Controller;
use App\Models\Mine\Miner;

class OilController extends Controller
{
    public function minePetrol()
    {
        Miner::find(\Auth::id())->increment('petrol', 10);

        return \Redirect::back();
    }

    public function mineKerosene()
    {
        $miner = Miner::find(\Auth::id());
        if ($miner->petrol > 0) {

            \DB::transaction(function () use ($miner) {
                $keroseneAmount = rand(6, 10);
                $miner->decrement('petrol', 10);
                $miner->increment('kerosene', $keroseneAmount);
            });
        }

        return \Redirect::back();
    }

    public function mineOil()
    {
        $miner = Miner::find(\Auth::id());
        if ($miner->kerosene > 0) {

            \DB::transaction(function () use ($miner) {
                $oilAmount = rand(6, 10);
                $miner->decrement('kerosene', 10);
                $miner->increment('oil', $oilAmount);
            });
        }

        return \Redirect::back();
    }

    public function mineWhater()
    {
        $miner = Miner::find(\Auth::id());
        if ($miner->oil > 0) {

            \DB::transaction(function () use ($miner) {
                $whaterAmount = rand(6, 10);
                $miner->decrement('oil', 10);
                $miner->increment('whater', $whaterAmount);
            });
        }

        return \Redirect::back();
    }
}
