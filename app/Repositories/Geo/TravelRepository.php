<?php

namespace App\Repositories\Geo;

use App\Models\Geo\Travel\TempShop;

class TravelRepository
{
    public static function getTravelShops()
    {
        $shops = TempShop::
            select(['id', 'date_ending'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), market_temp_shops.date_ending) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();

        return $shops;
    }
}
