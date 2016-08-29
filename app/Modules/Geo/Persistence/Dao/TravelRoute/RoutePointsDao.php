<?php

namespace App\Modules\Geo\Persistence\Dao\TravelRoute;

class RoutePointsDao
{
    private $table = 'geo_travel_route_points';

    public function create($route_id, $location_id, $status, $number)
    {
        $node_id =
            \DB::table($this->table)->insertGetId([
                'route_id' => $route_id,
                'location_id' => $location_id,
                'status' => $status,
                'number' => $number,
            ]);

        return $node_id;
    }

    public function find($id)
    {
        $pointData =
            \DB::table($this->table)
                ->select(['id', 'title'])
                ->find($id);

        return $pointData;
    }

    public function getByRoute($route_id)
    {
        $pointsData =
            \DB::table($this->table . ' AS po')
                ->select(['po.id', 'po.route_id', 'po.number', 'po.status', 'po.location_id', 'lo.title AS location_title'])
                ->join('geo_locations AS lo', 'lo.id', '=', 'po.location_id')
                ->where('route_id', $route_id)
                ->orderBy('number', 'asc')
                ->get();

        return $pointsData;
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

    public function delete($id)
    {
        return
            \DB::table($this->table)->delete($id);
    }
}
