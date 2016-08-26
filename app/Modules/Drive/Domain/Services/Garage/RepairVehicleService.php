<?php

namespace App\Modules\Drive\Domain\Services\Garage;

use App\Modules\Drive\Domain\Entities\Garage\RepairVehicle;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;

class RepairVehicleService
{
    /** @var VehiclesRepo */ 
    private $vehiclesRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function repair($vehicle_id)
    {
        /** @var RepairVehicle $repairVehicle */
        $repairVehicle = $this->vehiclesRepo->findRepairVehicle($vehicle_id);

        // просто починить
        $repairVehicle->repairOn(10);

        $this->vehiclesRepo->updateRepairData($repairVehicle);
    }

    public function recovery($vehicle_id)
    {
        /** @var RepairVehicle $repairVehicle */
        $repairVehicle = $this->vehiclesRepo->findRepairVehicle($vehicle_id);

        $repairVehicle->recoveryAfterBreaking();

        $this->vehiclesRepo->updateRepairData($repairVehicle);
    }

    public function fuel($vehicle_id, $litres)
    {
        /** @var RepairVehicle $repairVehicle */
        $repairVehicle = $this->vehiclesRepo->findRepairVehicle($vehicle_id);

        $repairVehicle->refuel($litres);

        $this->vehiclesRepo->updateRepairData($repairVehicle);
    }
}
