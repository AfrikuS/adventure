<?php

namespace App\Modules\Drive\Domain\Services\Garage;

use App\Modules\Drive\Domain\Entities\Garage\RepairVehicle;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;

class RepairVehicleService
{
    /** @var VehiclesRepo */ 
    private $vehiclesRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function repair(RepairVehicle $vehicle)
    {
        // просто починить
        $vehicle->repairOn(10);

        $this->vehiclesRepo->updateRepairData($vehicle);
    }

    public function recovery(RepairVehicle $vehicle)
    {
        $vehicle->recoveryAfterBreaking();

        $this->vehiclesRepo->updateRepairData($vehicle);
    }

    public function fuel(RepairVehicle $vehicle, $litres)
    {
        $vehicle->refuel($litres);

        $this->vehiclesRepo->updateRepairData($vehicle);
    }
}
