<?php

namespace App\Repositories;

use App\Models\Sea\TravelOrder;
use App\Models\Sea\TravelShip;
use Carbon\Carbon;

class SeaRepository
{
    public static function createOrderOnTravel(TravelShip $travel, $timeMinutes)
    {
        $dt = Carbon::create()->addMinutes($timeMinutes)->toDateTimeString();

        $order = TravelOrder::create([
            'destination' => $travel->destination,
            'resource_code' => $travel->resource_code,
            'date_time' => $dt,
            'user_id' => auth()->id,
            'travel_id' => $travel->id,
        ]);
        
        return $order;
    }
}
