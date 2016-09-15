<?php

namespace App\Modules\Drive\Actions\Garage;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Repairer;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Domain\Services\Garage\RepairVehicleService;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use App\Modules\Drive\Persistence\Repositories\Workroom\RepairerRepo;
use Finite\Exception\StateException;

class RepairVehicleAction
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;
    
    /** @var RepairerRepo */
    private $repairerRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
        $this->repairerRepo = app('RepairerRepo');
    }

    public function repair($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);

        $repairer = $this->repairerRepo->findBy($driver_id);

        $this->validateAction($vehicle, $repairer);

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

    private function validateAction(Vehicle $vehicle, Repairer $repairer)
    {
        if ($repairer->level === 0) {

            throw new StateException('Сначала нужно установить "Заправщик"');
        }
    }
}
