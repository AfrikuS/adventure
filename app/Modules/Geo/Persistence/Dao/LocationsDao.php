<?php

namespace App\Modules\Geo\Persistence\Dao;

use App\Models\Geo\Location;

class LocationsDao
{
    private $table = 'geo_locations';
    private $relationsTable = 'geo_location_paths';

    public function getLocations()
    {
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

//    /** @deprecated */
//    public function getNextIdsBy($id)
//    {
//        $next_ids =
//            \DB::table($this->relationsTable)
//                ->where('from_id', $id)
//                ->pluck('to_id AS id');
//
//        return $next_ids;
//    }

    public function getExcludeIds($id) // exlude self_id
    {
        $ids =
            \DB::table($this->table)
                ->where('id', '<>', $id)
                ->pluck('id');

        return $ids;
    }

    /** @deprecated */
    public function createRelation($from_id, $to_id)
    {
        $relation_id =
            \DB::table($this->relationsTable)->insertGetId([
                'from_id' => $from_id,
                'to_id' => $to_id,
            ]);

        return $relation_id;
    }

    /** @deprecated */
    public function removeRelation($from_id, $to_id)
    {
        return
            \DB::table($this->relationsTable)
                    ->where('from_id', $from_id)
                    ->where('to_id', $to_id)
                    ->delete();
    }
}
