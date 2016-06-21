<?php

namespace App\Serializers;

use App\Models\AuctionLot;
use Illuminate\Support\Facades\Redis;

class RedisAuctionLot
{
    /**
     * @param AuctionLot $lot
     * @deprecated
     */
    public static function saveLotViaString(AuctionLot $lot)
    {
        $lotData = [
            'user_id' => '',
            'user_name' => '',
            'bid' => strval($lot->bid)
        ];

        $lotDataStr = json_encode($lotData);
        Redis::set('auction_lot:' . strval($lot->id), $lotDataStr);
    }

    public static function saveLotInRedis(AuctionLot $lot)
    {
        // redis have id same with db id
        $key = 'lots_new:';

        Redis::hmset($key  . $lot->id, [
            'owner_id' => $lot->owner_id,
            'owner_name' => $lot->owner_user_name,
            'thing_id' => $lot->thing_id,
            'thing_title' => $lot->thing_title,
            'bid' => $lot->bid,
        ]);
    }

    public static function deleteLot($lot_id)
    {
        $key = 'lots_new:';

        Redis::del($key  . $lot_id);
    }
}
