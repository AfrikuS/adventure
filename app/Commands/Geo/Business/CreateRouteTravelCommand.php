<?php

namespace App\Commands\Geo\Business;

use App\Factories\GeoFactory;

class CreateRouteTravelCommand
{
    public function createRoute($trader_id, $routeTitle, $startLocation_id)
    {
        \DB::beginTransaction();
        
        try {
            $route = GeoFactory::createRoute($trader_id, $routeTitle, $startLocation_id);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();

        return $route;
    }
}
