<?php

namespace App\Modules\Drive\Actions\Drive\Vehicle;

use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Domain\Services\Garage\RepairVehicleService;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;

class RecoveryVehicleAction
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function recovery($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);

        $this->validateAction($vehicle);

        $repairService = new RepairVehicleService();

        \DB::beginTransaction();
        try {

            $repairService->recovery($vehicle);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateAction(Vehicle $vehicle)
    {

    }
}
