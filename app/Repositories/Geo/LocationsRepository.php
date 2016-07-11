<?php

namespace App\Repositories\Geo;

use App\Models\Geo\Location;

class LocationsRepository
{
    public static function getLocationsWithNexts()
    {
        return Location::select('id', 'title')->with(['locationsTo' => function($query) {
                    $query->select('geo_locations.title', 'geo_locations.id');
                }])->get();
    }

    public function createLocation($title)
    {
        $location = Location::create([
            'title' => $title,
        ]);

        return $location;
    }

    public function findById($id)
    {
        return Location::find($id);
    }
}
