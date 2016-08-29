<?php

namespace App\Repositories\Geo;

use App\Models\Geo\TravelRoute;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;

class TravelRoutesRepository
{
    /** @var TravelRoutesRepo */
    private $routesRepo;

    public function __construct()
    {
        $this->routesRepo = app('TravelRoutesRepo');
    }

    public static function getRoutes()
    {
        $routesRepo = app('TravelRoutesRepo');
        
        return $routesRepo->get();
    }

    public static function findTravelWithPointsById($id)
    {
        $routesRepo = app('TravelRoutesRepo');

        return $routesRepo->findTravelWithPointsById($id);

    }


    public static function findById($id)
    {
        $routesRepo = app('TravelRoutesRepo');

        return $routesRepo->findById($id);


    }

}
