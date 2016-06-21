<?php

namespace App\Repositories;

use App\Models\Sea\TravelOrder;
use App\Models\Sea\TravelShip;
use Illuminate\Support\Facades\DB;

class TravelRepository
{
    public static function getTravelShips()
    {
        $travels = TravelShip::
            select(['id', 'destination', 'resource_code'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), sea_travel_ships.date_sending) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();
        
        return $travels;    
    }
    
    public static function getActiveOrdersTimersByUser($user_id)
    {
        $ordersTimers = TravelOrder::
            where('sea_travel_orders.user_id', '=', $user_id)
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), sea_travel_orders.date_time) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();

        return $ordersTimers;
    }
}
