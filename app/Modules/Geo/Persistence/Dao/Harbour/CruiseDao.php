<?php

namespace App\Modules\Geo\Persistence\Dao\Harbour;

class CruiseDao
{
    private $table = 'geo_travel_live_voyages';

    public function find($id)
    {
        $cruiseData =
            \DB::table($this->table)
                ->select(['id', 'location_id', 'status', 'traveler_id'])
                ->find($id);

        return $cruiseData;
    }

    public function findBy($user_id)
    {
        $cruiseData =
            \DB::table($this->table)
                ->select(['id', 'location_id', 'status', 'traveler_id'])
                ->where('traveler_id', $user_id)
                ->first();

        return $cruiseData;
    }

    public function create($user_id, $location_id, $status)
    {
        return
            \DB::table($this->table)->insertGetId([
                'traveler_id' => $user_id,
                'location_id' => $location_id,
                'status' => $status,
            ]);
    }

    public function update($id, $nextLocation_id, $status)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'location_id' => $nextLocation_id,
                    'status' => $status,
                ]);
    }
}
