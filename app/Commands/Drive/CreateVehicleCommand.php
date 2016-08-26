<?php

namespace App\Commands\Drive;

use App\Models\Drive\Vehicle;
use App\Repositories\Drive\VehicleRepository;

/** @deprecated  */
class CreateVehicleCommand
{
    /** @var VehicleRepository */
    private $vehicleRepo;

    public function __construct(VehicleRepository $vehicleRepo)
    {
        $this->vehicleRepo = $vehicleRepo;
    }

    /** @deprecated  */
    public function createVehicle($driver_id): Vehicle
    {
        
        $this->vehicleRepo->createVehicle($driver_id);
    }
}
