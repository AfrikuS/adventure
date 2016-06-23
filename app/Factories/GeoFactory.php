<?php

namespace App\Factories;

use App\Models\Geo\Location;

class GeoFactory
{
    public static function createLocation(string $title)
    {
        return Location::create([
            'title' => $title,
        ]);
    }


}
