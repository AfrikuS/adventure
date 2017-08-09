<?php

namespace App\Modules\Dozor\Persistence\RedisDao;

use Illuminate\Support\Facades\Redis;

class DozorDao
{
    public function createDozorEntry($user_id, $status, $time)
    {
        $key = 'dozor:';

        Redis::hmset($key.$user_id, [
            'status'  => $status,
            'time'    => $time,
        ]);
    }

    public function updateStatusAndTime($user_id, $status, $time)
    {
        $key = 'dozor:';

        Redis::hmset($key.$user_id, [
            'status'  => $status,
            'time'    => $time,
        ]);
    }

    public function find($user_id)
    {
        $key = 'dozor:';
        
        $quest = Redis::hgetAll($key. $user_id);
        
        return $quest;
    }
}
