<?php

namespace App\Modules\Geo\Persistence\Dao;

use App\Modules\Geo\Domain\Entities\Business\TravelRoute;

class TravelRoutesDao
{
    private $table = 'geo_travel_routes';

    public function create($trader_id, $routeTitle, $status)
    {
        $route_id =
            \DB::table($this->table)->insertGetId([
                'title' => $routeTitle,
                'user_id' => $trader_id,
                'status' => $status,
            ]);

        return $route_id;
    }

    public function find($id)
    {
        $routeData =
            \DB::table($this->table)
                ->select(['id', 'title', 'user_id', 'status'])
                ->find($id);

        return $routeData;
    }


    public function get()
    {
        $routesData =
            \DB::table($this->table)
                ->select(['id', 'title', 'user_id', 'status'])
                ->get();

        return $routesData;
    }

    public function update($id, $status)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                ]);
    }

    public function getByStatus($status)
    {
        $routesData =
            \DB::table($this->table)
                ->select(['id', 'title', 'user_id', 'status'])
                ->where('status', $status)
                ->get();

        return $routesData;
    }
}
