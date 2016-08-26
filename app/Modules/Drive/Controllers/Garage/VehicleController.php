<?php

namespace App\Modules\Drive\Controllers\Garage;

use App\Exceptions\DetailNotFoundExeption;
use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Http\Controllers\Drive\DriveController;
use App\Modules\Drive\Commands\Garage\MountDetailCommand;
use App\Modules\Drive\Commands\Garage\UnmountDetailCommand;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use App\Repositories\Drive\DetailRepository;
use App\Repositories\Drive\DriverRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VehicleController extends DriveController
{

    /** @var DetailRepository */
    private $detailRepo;
    
    public function __construct(DriverRepository $driverRepo,
                                DetailRepository $detailRepo)
    {
        parent::__construct($driverRepo);

//        $this->detailRepo = $detailRepo;

    }

    public function index()
    {
        $driver_id = $this->user_id;

        /** @var DetailsRepo $detailsRepo */
        $detailsRepo = app('DriveDetailsRepo');

        $driverDetails = $detailsRepo->getUnmountedDetailsByDriver($driver_id);

        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $activeVehicle = $vehicleRepo->findActiveByDriver($driver_id);

        
        $detailsOnVehicle = $vehicleRepo->getMountedDetails($activeVehicle->id);
        

        return $this->view('drive.garage.vehicle', [
            'driverDetails' => $driverDetails,
            'vehicleDetails' => $detailsOnVehicle,
            'vehicle' => $this->vehicle,
        ]);
    }

    // redo on module
    public function equipToRaid()
    {
        /** @var DetailsRepo $detailsRepo */
        $detailsRepo = app('DriveDetailsRepo');

        $driverDetails = $detailsRepo->getUnmountedDetailsByDriver($this->user_id);

//        $driverDetails = $this->detailRepo->getUnmountedDetailsByDriverId($this->driver->id);
        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $activeVehicle = $vehicleRepo->findActiveByDriver($this->user_id);


        $detailsOnVehicle = $vehicleRepo->getMountedDetails($activeVehicle->id);

        // details on vehicle
//        $detailsOnVehicle = $this->vehicle->details;

        return $this->view('drive.garage.vehicle_equip', [
            'driverDetails' => $driverDetails,
            'vehicleDetails' => $detailsOnVehicle,
            'vehicle' => $this->vehicle,
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
        catch (EntityNotFound_Exception $e) {

            Session::flash('message', 'Нет такой детали');
        }
        

        return Redirect::route('drive_garage_vehicle_page');
    }

    public function unmountDetail()
    {
        $data = Input::all();
        $detail_id = $data['detail_id'];

        $cmd = new UnmountDetailCommand($this->detailRepo);

        
        try {

            $cmd->unmountDetail($detail_id, $this->user_id);

        }
        catch (DetailNotFoundExeption $e) {

            Session::flash('message', 'Такой детали не существует!');
        }

        
        return Redirect::route('drive_garage_vehicle_page');
    }
}
