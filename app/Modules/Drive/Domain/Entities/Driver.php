<?php

namespace App\Modules\Drive\Domain\Entities;

class Driver
{
    public $id;
    public $status;
    public $active_vehicle_id;

    public function __construct($driverData)
    {
        $this->id = $driverData->id;
        $this->status = $driverData->status;
        $this->active_vehicle_id = $driverData->active_vehicle_id;
    }
}
