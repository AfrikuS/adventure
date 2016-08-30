<?php

namespace App\Modules\Drive\Domain\Entities;

class Driver
{
    const STATUS_IN_RAID = 'in raid';

    public $id;
    public $status;
    public $vehicle_id;

    public function __construct(\stdClass $driverData)
    {
        $this->id = $driverData->id;
        $this->status = $driverData->status;
        $this->vehicle_id = $driverData->active_vehicle_id;
    }
}
