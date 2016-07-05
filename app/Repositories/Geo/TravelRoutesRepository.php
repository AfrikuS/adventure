<?php

namespace App\Repositories\Geo;

use App\Models\Geo\TravelRoute;

class TravelRoutesRepository
{
    public static function getRoutes()
    {
        return TravelRoute::select('id', 'title')->get();
    }

    public static function findTravelWithPointsById($id)
    {
        return TravelRoute::
            select('id', 'status', 'user_id')
            ->with(['points' => function($query) {
                $query->select('id', 'location_id', 'status', 'number', 'route_id');
            }])
            ->find($id);
    }


    public static function findById($id)
    {
        return TravelRoute::with(['points' => function($query) {
                    $query->select('location_id', 'status', 'number', 'route_id', 'id')
                        ->with(['location' => function($query) {
                            $query->select('id', 'title');
                        }]);
                    }])
                    ->select('id', 'title')
                    ->find($id);
    }

}
