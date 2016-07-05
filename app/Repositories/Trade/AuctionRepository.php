<?php

namespace App\Repositories\Trade;

use App\Models\Core\Thing;
use App\Models\Trade\AuctionLot;

class AuctionRepository
{
    public function findLotById($id)
    {
        return AuctionLot::with('thing')->find($id, ['id', 'owner_id', 'thing_id','bid']);
    }

    public function getActiveLots()
    {
        $lots = AuctionLot::
            select(['id', 'title', 'bid', 'owner_user_name', 'purchaser_user_name'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();

        return $lots;
    }

    public function getExpiredLots()
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

    public function deleteLotById($id)
    {
        AuctionLot::destroy($id);
    }

}
