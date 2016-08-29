<?php

namespace App\Modules\Geo\Actions\Business;

use App\Modules\Geo\Domain\Entities\Business\TravelRoute;
use App\Modules\Geo\Domain\Services\TravelRouteBuilder;
use App\Modules\Geo\Persistence\Repositories\Business\VoyagesRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use Finite\Exception\StateException;

class UncommitRouteCommand
{
    /** @var TravelRoutesRepo */
    private $routesRepo;
    
    /** @var VoyagesRepo */
    private $voyagesRepo;

    public function __construct()
    {
        $this->routesRepo = app('TravelRoutesRepo');
        $this->voyagesRepo = app('VoyagesRepo');
    }

    public function uncommit($route_id)
    {
        $route = $this->routesRepo->find($route_id);
        
        $this->validate($route);

        $routeBuilder = new TravelRouteBuilder();

        
        \DB::beginTransaction();

        try {
            
            $routeBuilder->uncommitRoute($route_id);
            
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }

    private function validate(TravelRoute $route)
    {
        if ($route->status !== TravelRoute::STATUS_COMMITTED) {

            throw new StateException;
        }
        
        $voyagesCountByRoute = $this->voyagesRepo->getCountByRoute($route);

        if ($voyagesCountByRoute > 0) {

            throw new StateException;
        }
    }
}
