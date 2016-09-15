<?php

namespace App\Modules\Geo\Persistence\Repositories\TravelRoute;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Geo\Domain\Entities\Business\RoutePoint;
use App\Modules\Geo\Persistence\Dao\TravelRoute\RoutePointsDao;

class RoutePointsRepo
{
    /** @var RoutePointsDao */
    private $routePointsDao;

    public function __construct(RoutePointsDao $routePointsDao)
    {
        $this->routePointsDao = $routePointsDao;
    }

    public function find($id)
    {
        $point = EntityStore::get(RoutePoint::class, $id);

        if (null != $point) {

            return $point;
        }

        $pointData = $this->routePointsDao->find($id);

        $point = new RoutePoint($pointData);

        EntityStore::add($point, $point->id);

        return $point;
    }

    public function getByRouteWithLocations($route_id)
    {
        $pointsData = $this->routePointsDao->getByRoute($route_id);

        $points = [];
        
        foreach ($pointsData as $pointData) {
            
            $point = new RoutePoint($pointData);
            $points[] = $point;
        }
        
        return $points;
            

        /*        $route = TravelRoute::with(['points' => function($query) {
                    $query->select('location_id', 'status', 'number', 'route_id', 'id')
                        ->with(['location' => function($query) {
                            $query->select('id', 'title');
                        }]);
                    }])
                    ->select('id', 'title')
                    ->find($id);*/

    }

    public function create($route_id, $location_id, $status, $pointNumber)
    {
        return
            $this->routePointsDao->create(
                $route_id,
                $location_id,
                $status,
                $pointNumber
            );
    }

    public function update(RoutePoint $node)
    {
        return
            $this->routePointsDao->update(
                $node->id,
                $node->status
            );
    }

    public function delete(RoutePoint $node)
    {
        $this->routePointsDao->delete($node->id);
    }

}
