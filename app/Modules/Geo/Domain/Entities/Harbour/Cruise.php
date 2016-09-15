<?php

namespace App\Modules\Geo\Domain\Entities\Harbour;

use App\Modules\Geo\Domain\Entities\Location;

class Cruise
{
    const STATUS_SAIL = 'in_sail';
    const STATUS_READY_SAIL = 'ready_to_sail';
    
    public $id;
    public $location_id;
    public $status;
    public $traveler_id;

    public $location;

    public function __construct(\stdClass $cruiseData)
    {
        $this->id = $cruiseData->id;
        $this->location_id = $cruiseData->location_id;
        $this->status = $cruiseData->status;
        $this->traveler_id = $cruiseData->traveler_id;
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    
}
