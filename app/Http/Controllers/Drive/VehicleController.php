<?php

namespace App\Http\Controllers\Drive;

use App\Commands\Drive\CreateVehicleCommand;
use App\Commands\Drive\Vehicle\MountDetailCommand;
use App\Commands\Drive\Vehicle\UnmountDetailCommand;
use App\Exceptions\DetailNotFoundExeption;
use App\Models\Drive\Vehicle;
use App\Repositories\Drive\DetailRepository;
use App\Repositories\Drive\DriverRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VehicleController extends AppController
{
    /** @var Vehicle  */
    protected $vehicle;

    /** @var DetailRepository */
    private $detailRepo;

    public function __construct(DriverRepository $driverRepo, DetailRepository $detailRepo)
    {
        parent::__construct($driverRepo);

        $this->detailRepo = $detailRepo;

        $this->vehicle = Vehicle::where('driver_id', $this->driver->id)->first();

        if (null === $this->vehicle) {
            
            $cmd = new CreateVehicleCommand();
            
            $this->vehicle = $cmd->createVehicle($this->driver->id);
        }
    }

    public function index()
    {
        // unmounted driver's details
        $driverDetails = $this->detailRepo->getUnmountedDetailsByDriverId($this->driver->id);
        
        // details on vehicle
        $detailsOnVehicle = $this->vehicle->details(); 

        return $this->view('drive.garage.vehicle', [
            'driverDetails' => $driverDetails,
            'vehicleDetails' => $detailsOnVehicle,
            'vehicle' => $this->vehicle,
        ]);
    }

    public function mountDetail()
    {
        $data = Input::all();
        $detail_id = $data['detail_id'];
        
        $cmd = new MountDetailCommand($this->detailRepo);


        try {

            $cmd->mountDetail($detail_id, $this->vehicle);

        }
        catch (DetailNotFoundExeption $e) {

            Session::flash('message', 'Такой детали не существует!');
        }
        

        return Redirect::route('drive_garage_vehicle_page');
    }

    public function unmountDetail()
    {
        $data = Input::all();
        $detail_id = $data['detail_id'];

        $cmd = new UnmountDetailCommand($this->detailRepo);

        
        try {

            $cmd->unmountDetail($detail_id, $this->vehicle);

        }
        catch (DetailNotFoundExeption $e) {

            Session::flash('message', 'Такой детали не существует!');
        }

        
        return Redirect::route('drive_garage_vehicle_page');
    }
}
