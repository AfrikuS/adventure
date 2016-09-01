<?php

namespace App\Modules\Drive\Actions\Garage;

use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Domain\Services\Garage\RepairVehicleService;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;

class RepairVehicleAction
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function repair($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);

        $this->validateAction($vehicle);

        $repairService = new RepairVehicleService();

        \DB::beginTransaction();
        try {


            $repairService->repair($vehicle);

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
