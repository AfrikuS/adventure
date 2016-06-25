<?php

namespace App\Repositories;

use App\Models\Hero\Thing;
use App\Models\Trade\AuctionLot;

class AuctionRepository
{
    // todo pagination
    public static function getActiveLots()
    {
        $lots = AuctionLot::
            select(['id', 'title', 'bid', 'owner_user_name', 'purchaser_user_name'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();

        return $lots;
    }

    public static function getThingsByUserId($userId)
    {
        $things = Thing::where('owner_id', $userId)->get(['id', 'title']);
        return $things;
    }

    public static function getExpiredLots()
    {
        $lots = AuctionLot::
            select(['id', 'title', 'date_time', 'owner_id', 'bid', 'thing_id'])
            ->whereRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) < 0')
            ->get();

        return $lots;
    }

    public static function getAllLots()
    {
        return AuctionLot::
            select(['id', 'title', 'bid', 'owner_user_name', 'owner_id', 'purchaser_user_name'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) AS duration_seconds')
            ->get();
    }


}
