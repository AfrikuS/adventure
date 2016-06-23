<?php

namespace App\Repositories\Geo;

use App\Models\Geo\TravelOrder;
use App\Models\Geo\TravelShip;
use Carbon\Carbon;

class SeaRepository
{
    public static function createOrderOnTravel($user, TravelShip $travel, int $timeMinutes)
    {
        $dt = Carbon::create()->addMinutes($timeMinutes)->toDateTimeString();

        $order = TravelOrder::create([
            'destination' => $travel->destination,
            'resource_code' => $travel->resource_code,
            'date_time' => $dt,
            'user_id' => $user->id,
            'travel_id' => $travel->id,
        ]);
        
        return $order;
    }
}
