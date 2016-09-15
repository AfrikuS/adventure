<?php

namespace App\Modules\Geo\Domain\Entities;

class Location
{
    public $id;
    public $title;

    /** @var array */
    public $nextLocations;
    
    public function __construct(\stdClass $locationData)
    {
        $this->id = $locationData->id;
        $this->title = $locationData->title;
        
        $this->nextLocations = [];
    }

    public function addNext(Location $location)
    {
        $this->nextLocations[$location->id] = $location;
    }

    public function isExistNextLocation($location_id)
    {
        return array_key_exists($location_id, $this->nextLocations);
    }
}
