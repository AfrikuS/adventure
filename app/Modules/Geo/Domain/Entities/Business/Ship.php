<?php

namespace App\Modules\Geo\Domain\Entities\Business;

use App\Modules\Geo\Domain\Entities\Business\TravelRoute;

class Ship
{
    public $id;
    public $owner_id;
    public $route_id;

    public function __construct(\stdClass $shipData)
    {
        $this->id = $shipData->id;
        $this->owner_id = $shipData->owner_id;
        $this->route_id = $shipData->route_id;
    }

    public function setOnRoute(TravelRoute $route)
    {
        $this->route_id = $route->id;
    }
}
