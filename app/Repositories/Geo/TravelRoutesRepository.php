<?php

namespace App\Repositories\Geo;

use App\Models\Geo\TravelRoute;

class TravelRoutesRepository
{
    public static function getRoutes()
    {
        return TravelRoute::select('id', 'title')->get();
    }

    public static function findById($id)
    {
//        return TravelRoute::
//            with(['route' => function($query) {
//                $query->select('title', 'id');
//            }])
//            ->with(['points' => function($query) {
//                $query->select('location_id', 'status', 'number', 'route_id', 'id');
//            }])
//            ->find($id, ['id', 'status', 'route_id', 'point_id']);

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
