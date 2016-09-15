<?php

namespace App\Modules\Geo\Persistence\Dao\Business;

class VoyagesDao
{
    private $table = 'geo_travel_voyages';

    public function getBy($route_id)
    {
        $voyagesData =
            \DB::table($this->table)
                ->select(['id', 'route_id', 'ship_id', 'point_id', 'status'])
                ->where('route_id', $route_id)
                ->get();

        return $voyagesData;
    }

    public function create($route_id, $ship_id, $point_id, $status)
    {
        return
            \DB::table($this->table)->insertGetId([
                'route_id' => $route_id,
                'ship_id' => $ship_id,
                'point_id' => $point_id,
                'status' => $status,
            ]);
    }

    public function find($id)
    {
        $voyageData =
            \DB::table($this->table)
                ->select(['id', 'route_id', 'ship_id', 'point_id', 'status'])
                ->find($id);

        return $voyageData;
    }


    public function update($id, $point_id, $status)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'point_id' => $point_id,
                    'status' => $status,
                ]);
    }

    public function getWithTitles($voyageStatus = null)
    {
        $query = 
            \DB::table($this->table . ' AS vo')
                ->select(['vo.id', 'vo.route_id', 'vo.ship_id', 'vo.point_id', 'vo.status',
                            'ro.title AS route_title', 'lo.title AS point_location_title'])
                ->join('geo_travel_routes AS ro', 'ro.id', '=', 'vo.route_id')

                ->join('geo_travel_route_points AS po', 'po.id', '=', 'vo.point_id')
                ->join('geo_locations AS lo', 'lo.id', '=', 'po.location_id');
                
        
        if ($voyageStatus) {
            $query->where('vo.status', $voyageStatus);
        }
        
        $voyagesData = $query->orderBy('vo.id', 'desc')->get();
        
        return $voyagesData;
    }

    public function updateStatus($id, $status)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'status' => $status,
                ]);
    }

    public function getCountByRoute($route_id)
    {
        $voyagesCount =
            \DB::table($this->table)
                ->where('route_id', $route_id)
                ->count();

        return $voyagesCount;
    }

}
