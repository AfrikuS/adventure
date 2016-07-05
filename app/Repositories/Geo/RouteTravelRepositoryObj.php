<?php

namespace App\Repositories\Geo;

use App\Models\Geo\TravelRoute;
use App\StateMachines\Geo\TravelRouteEntity;

class RouteTravelRepositoryObj
{
    public function findTravelWithPointsById($id)
    {
        $route = TravelRoute::
            select('id', 'status', 'user_id')
            ->with(['points' => function($query) {
                $query->select('id', 'location_id', 'status', 'number', 'route_id');
            }])
            ->find($id);
        
        return new TravelRouteEntity($route);
    }

}
