<?php

namespace App\Modules\Drive\Controllers\Garage;

use App\Modules\Core\Http\Controller;
use App\Modules\Drive\Actions\Garage\RecoveryVehicleAction;
use App\Modules\Drive\Actions\Garage\RefuelVehicleAction;
use App\Modules\Drive\Actions\Garage\RepairVehicleAction;
use App\Modules\Drive\Persistence\Repositories\DriversRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Illuminate\Support\Facades\Redirect;

class WorkroomController extends Controller
{
    /** @var DriversRepo */
    private $driversRepo;

    public function __construct()
    {
        parent::__construct();

        $this->driversRepo = app('DriveDriversRepo');
    }

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
//        $driver = $this->driversRepo->findById($this->user_id);
        
        
        $repair = new RepairVehicleAction();
        
        $repair->repair($this->user_id);
        
        

        return Redirect::route('drive_workroom_page');
    }

    public function recovery()
    {
//        $driver = $this->driversRepo->findById($this->user_id);

        
        
        $recoveryVehicleAction = new RecoveryVehicleAction();

        $recoveryVehicleAction->recovery($this->user_id);

        

        return Redirect::route('drive_workroom_page');
    }

    public function refuel()
    {
        
        $refuelAction = new RefuelVehicleAction();
        
        $refuelAction->refuel($this->user_id);
        

        return Redirect::route('drive_workroom_page');
    }

}
