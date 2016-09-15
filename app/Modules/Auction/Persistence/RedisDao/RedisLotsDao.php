<?php

namespace App\Modules\Auction\Persistence\RedisDao;

use Illuminate\Support\Facades\Redis;

class RedisLotsDao
{
    public function saveLotInRedis($id, $owner_id, $ownerName, $thing_id, $thingTitle, $bid)
    {
        // redis have id same with db id
        $key = 'lots_new:';

        Redis::hmset($key.$id, [
            'owner_id'    => $owner_id,
            'owner_name'  => $ownerName,
            'thing_id'    => $thing_id,
            'thing_title' => $thingTitle,
            'bid'         => $bid,
        ]);
    }

    public static function deleteLot($lot_id)
    {
        $key = 'lots_new:';

        Redis::del($key  . $lot_id);
    }

}
