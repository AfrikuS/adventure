<?php

namespace App\Factories\Geo;

use App\Models\Geo\RoutePoint;

class RouteTravelFactory
{
    public function createRoutePoint(int $route_id, $location_id, $pointNumber)
    {
        return RoutePoint::create([
            'route_id' => $route_id,
            'location_id' => $location_id,
            'status' => 'normal',
            'number' => $pointNumber,
        ]);
    }
}
