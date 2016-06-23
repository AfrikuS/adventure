<?php

namespace App\Factories;

use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\TravelRoute;

class GeoFactory
{
    public static function createLocation(string $title)
    {
        return Location::create([
            'title' => $title,
        ]);
    }

    public static function createRoute($user, string $title, int $startLocation_id)
    {
        return \DB::transaction(function () use ($user, $title, $startLocation_id) {

            $route = TravelRoute::create([
                'title' => $title,
                'user_id' => $user->id,
            ]);

            RoutePoint::create([
                'route_id' => $route->id,
                'location_id' => $startLocation_id,
                'status' => 'first',
                'number' => 1,
            ]);
            
            return $route;
        });
    }

    public static function createRoutePoint(TravelRoute $route, $location_id)
    {
        $pointsCount = $route->points->count();

        return RoutePoint::create([
            'route_id' => $route->id,
            'location_id' => $location_id,
            'status' => 'normal',
            'number' => $pointsCount + 1,
        ]);
    }

}
