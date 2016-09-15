<?php

namespace App\Modules\Geo\Persistence\Dao\Business;

class ShipsDao
{
    private $table = 'geo_trader_ships';
    private $tableAlias;

    public function getByOwner($owner_id)
    {
        $shipsData =
            \DB::table($this->table)
                ->select(['id', 'owner_id', 'route_id'])
                ->where('owner_id', $owner_id)
                ->get();

        return $shipsData;
    }

    public function getByRoute($route_id)
    {
        $shipsData =
            \DB::table($this->table)
                ->select(['id', 'owner_id', 'route_id'])
                ->where('route_id', $route_id)
                ->get();

        return $shipsData;
    }

    public function update($id, $route_id)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'route_id' => $route_id,
                ]);
    }

    public function find($id)
    {
        $shipData =
            \DB::table($this->table)
                ->select(['id', 'owner_id', 'route_id'])
                ->find($id);

        return $shipData;
    }

    public function getFreeByOwner($user_id)
    {
        $shipsData =
            \DB::table($this->table)
                ->select(['id', 'owner_id', 'route_id'])
                ->where('owner_id', $user_id)
                ->where('route_id', null)
                ->get();

        return $shipsData;
    }

    public function create($owner_id, $route_id = null)
    {
        return
            \DB::table($this->table)->insertGetId([
                'owner_id' => $owner_id,
                'route_id' => $route_id,
            ]);
    }
}
