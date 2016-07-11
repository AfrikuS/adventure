<?php

namespace App\Commands\Geo\Business;

use App\Repositories\Geo\RouteTravelRepositoryObj;

class CommitRouteCommand
{
    /** @var RouteTravelRepositoryObj */
    protected $routeRep;

    public function __construct(RouteTravelRepositoryObj $routeRep)
    {
        $this->routeRep = $routeRep;
    }

    public function commitRoute($route_id)
    {
        $routeEntity = $this->routeRep->findTravelWithPointsById($route_id);

        \DB::beginTransaction();

        try {
            $routeEntity->commit();
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }
}
