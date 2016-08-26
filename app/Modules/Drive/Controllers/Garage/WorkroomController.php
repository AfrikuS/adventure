<?php

namespace App\Modules\Drive\Controllers\Garage;

use App\Modules\Drive\Controllers\DriveController;
use App\Modules\Drive\Domain\Services\Garage\RepairVehicleService;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Illuminate\Support\Facades\Redirect;

class WorkroomController extends DriveController
{
    public function index()
    {
        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $vehicle = $vehicleRepo->findActiveByDriver($this->user_id);

        
        return $this->view('drive.garage.workroom', [
            'vehicle' => $vehicle,
        ]);
    }

    public function repair()
    {
        $vehicle_id = 1; //$this->driver->active_vehicle_id;
        
        $repairService = new RepairVehicleService();


        $repairService->repair($vehicle_id);

        return Redirect::route('drive_workroom_page');
    }

    public function recovery()
    {
        $vehicle_id = 1; //$this->driver->active_vehicle_id;

        $repairService = new RepairVehicleService();


        $repairService->recovery($vehicle_id);


        return Redirect::route('drive_workroom_page');
    }

    public function refuel()
    {
        $vehicle_id = 1; //$this->driver->active_vehicle_id;

        $repairService = new RepairVehicleService();


        $repairService->fuel($vehicle_id, 3);

        return Redirect::route('drive_workroom_page');
    }

}
