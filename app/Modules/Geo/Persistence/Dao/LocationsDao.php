<?php

namespace App\Modules\Geo\Persistence\Dao;

use App\Models\Geo\Location;

class LocationsDao
{
    private $table = 'geo_locations';
    private $relationsTable = 'geo_location_paths';

    public function getByHero($hero_id)
    {
//        $buildings =
//            \DB::table($this->table)
//                ->select(['id', 'gates_level', 'fence_level', 'door_house_level',
//                    'door_ambar_level', 'door_resource_warehause_level'])
//                ->find($hero_id);
//
//        return $buildings;
    }

    public function getLocations()
    {
//        return
//            Location::select('id', 'title')->with(['locationsTo' => function($query) {
//                $query->select('geo_locations.title', 'geo_locations.id');
//            }])->get();

        $locationsData =
            \DB::table($this->table)
                ->select(['id', 'title'])
                ->get();

        return $locationsData;
    }

    public function create($title)
    {
        $location_id = 
            \DB::table($this->table)->insertGetId([
                'title' => $title,
            ]);

        return $location_id;
    }

    public function find($id)
    {
        $locationData =
            \DB::table($this->table)
                ->select(['id', 'title'])
                ->find($id);

        return $locationData;
    }

    public function getNextIdsBy($id)
    {
        $next_ids =
            \DB::table($this->relationsTable)
                ->where('from_id', $id)
                ->pluck('to_id AS id');
        
        return $next_ids;
    }

    public function getExcludeIds($id) // exlude self_id
    {
        $ids =
            \DB::table($this->table)
                ->where('id', '<>', $id)
                ->pluck('id');

        return $ids;
    }

    public function createRelation($from_id, $to_id)
    {
        $relation_id =
            \DB::table($this->relationsTable)->insertGetId([
                'from_id' => $from_id,
                'to_id' => $to_id,
            ]);

        return $relation_id;
    }

    public function removeRelation($from_id, $to_id)
    {
        return
            \DB::table($this->relationsTable)
                    ->where('from_id', $from_id)
                    ->where('to_id', $to_id)
                    ->delete();
    }
}
