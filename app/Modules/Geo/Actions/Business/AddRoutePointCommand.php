<?php

namespace App\Modules\Geo\Actions\Business;

use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Domain\Services\TravelRouteBuilder;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use Finite\Exception\StateException;

class AddRoutePointCommand
{
    /** @var TravelRoutesRepo */
    private $routesRepo;

    public function __construct()
    {
        $this->routesRepo = app('TravelRoutesRepo');
    }

    public function addRoutePont($route_id, $location_id)
    {
        $route = $this->routesRepo->find($route_id);

        $this->validateAction($route);

        $routeBuilder = new TravelRouteBuilder();
        
        \DB::beginTransaction();

        try {

            $routeBuilder->addRoutePoint($route_id, $location_id);
            
            
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }

    private function validateAction(TravelRoute $route)
    {
        if ($route->status !== TravelRoute::STATUS_DRAFT) {

            throw new StateException;
        }
    }
}
