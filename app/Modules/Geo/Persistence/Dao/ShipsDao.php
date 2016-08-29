<?php

namespace App\Modules\Geo\Persistence\Dao;

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
}
