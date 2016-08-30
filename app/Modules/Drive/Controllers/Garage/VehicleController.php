<?php

namespace App\Modules\Drive\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Modules\Drive\Commands\Garage\MountDetailCommand;
use App\Modules\Drive\Commands\Garage\UnmountDetailCommand;
use App\Modules\Drive\Persistence\Repositories\Vehicle\DetailsRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VehicleController extends Controller
{
    public function index()
    {
        $driver_id = $this->user_id;

        /** @var DetailsRepo $detailsRepo */
        $detailsRepo = app('DriveDetailsRepo');

        $driverDetails = $detailsRepo->getUnmountedDetailsByDriver($driver_id);

        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $activeVehicle = $vehicleRepo->findActiveByDriver($driver_id);

        
        $detailsOnVehicle = $detailsRepo->getMountedDetails($activeVehicle->id);
        

        return $this->view('drive.garage.vehicle', [
            'driverDetails' => $driverDetails,
            'vehicleDetails' => $detailsOnVehicle,
        ]);
    }

    public function equipToRaid()
    {
        /** @var DetailsRepo $detailsRepo */
        $detailsRepo = app('DriveDetailsRepo');

        $driverDetails = $detailsRepo->getUnmountedDetailsByDriver($this->user_id);

        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $activeVehicle = $vehicleRepo->findActiveByDriver($this->user_id);


        $detailsOnVehicle = $detailsRepo->getMountedDetails($activeVehicle->id);


        return $this->view('drive.garage.vehicle_equip', [
            'driverDetails' => $driverDetails,
            'vehicleDetails' => $detailsOnVehicle,
        ]);
    }
    
    public function mountDetail()
    {
        $data = Input::all();
        $detail_id = $data['detail_id'];
        
        $cmd = new MountDetailCommand();


        try {

            $cmd->mountDetail($detail_id, $this->user_id);

        }
        catch (StateException $e) {

            Session::flash('message', $e->getMessage());
        }
        

        return Redirect::route('drive_garage_vehicle_page');
    }

    public function unmountDetail()
    {
        $data = Input::all();
        $detail_id = $data['detail_id'];

        $cmd = new UnmountDetailCommand();

        
        try {

            $cmd->unmountDetail($detail_id, $this->user_id);

        }
        catch (StateException $e) {

            Session::flash('message', $e->getMessage());
        }

        return Redirect::route('drive_garage_vehicle_page');
    }
}
