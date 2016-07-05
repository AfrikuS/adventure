<?php

namespace App\Commands\Geo\Business;

use App\Repositories\Geo\RouteTravelRepositoryObj;

class DeleteLastRoutePointCommand
{
    /** @var RouteTravelRepositoryObj */
    protected $routeRep;

    public function __construct(RouteTravelRepositoryObj $routeRep)
    {
        $this->routeRep = $routeRep;
    }

    public function deleteLastPointFromRoute($route_id)
    {
        $routeEntity = $this->routeRep->findTravelWithPointsById($route_id);

        \DB::beginTransaction();

        try {

            $routeEntity->deleteLastPoint();
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();

    }

}
