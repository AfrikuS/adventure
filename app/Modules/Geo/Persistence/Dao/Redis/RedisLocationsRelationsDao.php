<?php

namespace App\Modules\Geo\Persistence\Dao\Redis;


use Illuminate\Support\Facades\Redis;

class RedisLocationsRelationsDao
{
    private $keyPrefix = 'GeoLocations:';

    public function addByLocation($locationFrom_id, $locationTo_id)
    {
        return
            Redis::sadd(
                $this->keyPrefix.$locationFrom_id, 
                $locationTo_id 
            );
    }

    public function getNextsByLocation($location_id)
    {
        return
            Redis::smembers(
                $this->keyPrefix.$location_id
            );
    }

    public function removeRelation($from_id, $to_id)
    {
        return
            Redis::srem(
                $this->keyPrefix.$from_id,
                $to_id
            );
    }
}
