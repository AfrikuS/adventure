<?php

namespace App\Modules\Geo\Actions\Business;

use App\Factories\GeoFactory;
use App\Modules\Geo\Domain\Services\TravelRouteBuilder;

class CreateRouteTravelCommand
{
    public function createRoute($trader_id, $routeTitle, $startLocation_id)
    {
        \DB::beginTransaction();
        
        $routeBuilder = new TravelRouteBuilder();
        
        try {

            $route_id = $routeBuilder->createRoute($trader_id, $routeTitle, $startLocation_id);
            
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();

        return $route_id;
    }
}
