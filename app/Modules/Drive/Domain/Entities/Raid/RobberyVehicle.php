<?php

namespace App\Modules\Drive\Domain\Entities\Raid;

class RobberyVehicle
{
    public $id;
    public $mobility;
    public $damage_percent;
    public $fuel_level;

    public function __construct(\stdClass $vehicleData)
    {
        $this->id = $vehicleData->id;
        $this->mobility = $vehicleData->mobility;
        $this->damage_percent = $vehicleData->damage_percent;
        $this->fuel_level = $vehicleData->fuel_level;
    }
}
