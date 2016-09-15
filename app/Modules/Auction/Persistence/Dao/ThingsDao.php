<?php

namespace App\Modules\Auction\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Modules\Auction\Domain\Entities\Thing;

class ThingsDao
{
    private $table = 'hero_things';

    public function find($id)
    {
        $thingData =
            \DB::table($this->table)
                ->select(['id', 'title', 'status', 'owner_id'])
                ->find($id);

        if (null === $thingData) {
            throw new EntityNotFound_Exception;
        }

        return $thingData;
    }

    public function getFreeThingsBy($hero_id)
    {
        $things =
            \DB::table($this->table)
                ->select(['id', 'title', 'status', 'owner_id'])
                ->where('owner_id', $hero_id)
                ->where('status', Thing::STATUS_FREE)
                ->get();

        return $things;
    }

    public function getBy($hero_id)
    {
        $things =
            \DB::table($this->table)
                ->select(['id', 'title', 'status', 'owner_id'])
                ->where('owner_id', $hero_id)
                ->get();

        return $things;
    }

    public function update($id, $status, $owner_id)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                    'owner_id' => $owner_id,
                ]);
    }
}
