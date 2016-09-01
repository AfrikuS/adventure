<?php

namespace App\Modules\Drive\Actions\Garage;

use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Domain\Services\Garage\RepairVehicleService;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Finite\Exception\StateException;

class RefuelVehicleAction
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function refuel($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);

        $this->validateAction($vehicle);

        $repairService = new RepairVehicleService();

        \DB::beginTransaction();
        try {


            $repairService->fuel($vehicle, 3);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateAction(Vehicle $vehicle)
    {
        if ($vehicle->fuel_level === 100) {

            throw new StateException('Full tank');
        }
    }
}
