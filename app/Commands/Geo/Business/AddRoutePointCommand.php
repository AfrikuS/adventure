<?php

namespace App\Commands\Geo\Business;

use App\Factories\Geo\RouteTravelFactory;
use App\Repositories\Geo\RouteTravelRepositoryObj;

class AddRoutePointCommand
{
    /** @var RouteTravelRepositoryObj */
    protected $routeRep;
    /** @var RouteTravelFactory */
    protected $routeFactory;

    public function __construct(RouteTravelRepositoryObj $routeRep, RouteTravelFactory $routeFactory)
    {
        $this->routeRep = $routeRep;
        $this->routeFactory = $routeFactory;
    }

    public function addRoutePont($route_id, $location_id)
    {
        $routeEntity = $this->routeRep->findTravelWithPointsById($route_id);

        \DB::beginTransaction();

        try {
            $pointNumber = $routeEntity->points->count() + 1;

            $point = $this->routeFactory->createRoutePoint($route_id, $location_id, $pointNumber);

            $routeEntity->addPoint($point);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }
}
