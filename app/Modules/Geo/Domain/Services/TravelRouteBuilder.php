<?php

namespace App\Modules\Geo\Domain\Services;

use App\Modules\Geo\Domain\Entities\Business\RoutePoint;
use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Persistence\Repositories\TravelRoute\RoutePointsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;

class TravelRouteBuilder
{
    /** @var RoutePointsRepo */
    private $routeNodesRepo;
    
    /** @var TravelRoutesRepo */
    private $routesRepo;

    public function __construct()
    {
        $this->routeNodesRepo = app('RoutePointsRepo');
        $this->routesRepo = app('TravelRoutesRepo');
    }

    public function createRoute($trader_id, $routeTitle, $firstLocation_id)
    {
        $route_id = $this->routesRepo->create(
            $trader_id,
            $routeTitle
        );

        
        $this->routeNodesRepo->create(
            $route_id,
            $firstLocation_id,
            RoutePoint::STATUS_FIRST,
            $number = 1);

        
        return $route_id;
    }

    public function addRoutePoint($route_id, $location_id)
    {
        $route = $this->routesRepo->find($route_id);

        $nodeNumber = count($route->points) + 1;
        
        $this->routeNodesRepo->create(
            $route_id,
            $location_id,
            RoutePoint::STATUS_NORMAL,
            $nodeNumber
        );
    }

    public function commitRoute($route_id)
    {
        $route = $this->routesRepo->find($route_id);

        
        $route->commit();
        
        $this->routesRepo->update($route);

        
        
        
        // BIG QUESTION WHY ??

        /** @var RoutePoint $lastPoint */
        $lastPoint = last($route->points);

        $lastPoint->setFinal();

        $this->routeNodesRepo->update($lastPoint);
    }

    public function uncommitRoute($route_id)
    {
        /** @var TravelRoute $route */
        $route = $this->routesRepo->find($route_id);


        $route->uncommit();

        $this->routesRepo->update($route);




        // BIG QUESTION WHY ??

        /** @var RoutePoint $lastPoint */
        $lastPoint = last($route->points);

        $lastPoint->setNormal();

        $this->routeNodesRepo->update($lastPoint);
    }

    public function deleteLastPoint($route_id)
    {
        $route = $this->routesRepo->find($route_id);

        /** @var RoutePoint $lastPoint */
        $lastPoint = last($route->points);

        $this->routeNodesRepo->delete($lastPoint);
    }
}
