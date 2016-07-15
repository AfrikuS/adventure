<?php

namespace App\Http\Controllers\Drive;

use App\Commands\Drive\CreateVehicleCommand;
use App\Commands\Drive\Raid\StartRaidCommand;
use App\Entities\Drive\RaidVehicle;
use App\Http\Controllers\Controller;
use App\Models\Drive\Driver;
use App\Models\Drive\Robbery;
use App\Models\Drive\Vehicle;
use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\RaidRepository;
use App\Repositories\Drive\VehicleRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DriveController extends Controller
{
    /** @var  DriverRepository */
    protected $driverRepo;
    /** @var  Driver */
    protected $driver;

    /** @var VehicleRepository */
    protected $vehicleRepo;
    /** @var RaidVehicle  */
    protected $vehicle;
    

    public function __construct(DriverRepository $driverRepo)
    {
        parent::__construct();

        $this->driverRepo = $driverRepo;

        $this->vehicleRepo = new VehicleRepository();

        
        $this->driver = $this->driverRepo->findById($this->user_id);

        $this->vehicle = $this->vehicleRepo->findSimpleVehicleByDriverId($this->driver->id);
    }

    public function startRaid(RaidRepository $raidRepo)
    {
        $data = Input::all();
        $vehicle_id = $data['vehicle_id'];

        $cmd = new StartRaidCommand($raidRepo);
        
        $cmd->createRaid($this->driver->id, $vehicle_id);


        return \Redirect::route('drive_raid_page');
    }

    
    protected function view($view = null, $data = [])
    {
        $data['driver'] = (object) $this->driver->toArray();
        $data['vehicle'] = $this->vehicle;

        return parent::view($view, $data);
    }

}
