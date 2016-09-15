<?php

namespace App\Modules\Drive\Actions\Garage;

use App\Modules\Drive\Domain\Entities\Garage\Workroom\Refueler;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Domain\Services\Garage\RepairVehicleService;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use App\Modules\Drive\Persistence\Repositories\Workroom\RefuelerRepo;
use Finite\Exception\StateException;

class RefuelVehicleAction
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;
    
    /** @var RefuelerRepo */
    private $refuelerRepo;

    public function __construct()
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
        $this->refuelerRepo = app('RefuelerRepo');
    }

    public function refuel($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);
        
        $refueler = $this->refuelerRepo->findBy($driver_id);

        $this->validateAction($vehicle, $refueler);

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

    private function validateAction(Vehicle $vehicle, Refueler $refueler)
    {
        if ($refueler->level === 0) {

            throw new StateException('Сначала нужно установить "Заправщик"');
        }
        
        if ($vehicle->fuel_level === 100) {

            throw new StateException('Full tank yet');
        }
    }
}
