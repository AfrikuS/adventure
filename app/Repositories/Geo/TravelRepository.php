<?php

namespace App\Repositories\Geo;

use App\Models\Geo\TravelOrder;
use App\Models\Geo\TravelShip;
use Illuminate\Support\Facades\DB;

class TravelRepository
{
    public static function getTravelShips()
    {
        $travels = TravelShip::
            select(['id', 'destination_location_id', 'date_sending'])
            ->with('destination')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), geo_travel_ships.date_sending) AS duration_seconds')

            ->havingRaw('duration_seconds > 0')
            ->get();
        
        return $travels;    
    }
    
    public static function getActiveOrdersTimersByUser($user_id)
    {
        $ordersTimers = TravelOrder::
            where('geo_travel_orders.traveler_id', $user_id)
//            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), geo_travel_orders.date_sending) AS duration_seconds')
//            ->havingRaw('duration_seconds > 0')
            ->get();

        return $ordersTimers;
    }
}
