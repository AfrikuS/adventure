<?php

namespace App\Modules\Drive\Controllers;

use App\Entities\Drive\RaidVehicle;
use App\Http\Controllers\Controller;
use App\Models\Drive\Driver;
use App\Modules\Drive\Commands\Raid\StartRaidCommand;
use App\Modules\Drive\Persistence\Repositories\DriversRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use App\Repositories\Drive\RaidRepository;
use App\Repositories\Drive\VehicleRepository;
use Illuminate\Support\Facades\Input;

class DriveController extends Controller
{
    /** @var  DriversRepo */
    protected $driversRepo;
    /** @var  Driver */
    protected $driver;

    /** @var VehiclesRepo */
    protected $vehicleRepo;
    /** @var RaidVehicle  */
    protected $vehicle;
    

    public function __construct()
    {
        parent::__construct();

        $this->driversRepo = app('DriveDriversRepo');

        $this->vehicleRepo = app('DriveVehiclesRepo');

        
//        $this->driver = $this->driversRepo->findById($this->user_id);
//
        $this->vehicle = $this->vehicleRepo->findViewVehicle($this->user_id);
    }

    public function startRaid()
    {
        $data = Input::all();
        $vehicle_id = $data['vehicle_id'];

        $cmd = new StartRaidCommand();
        
        $cmd->createRaid($this->driver->id, $vehicle_id);


        return \Redirect::route('drive_raid_page');
    }

    
    protected function view($view = null, $data = [])
    {
//        $data['driver'] = $this->driver;
        $data['vehicle'] = $this->vehicle;

        return parent::view($view, $data);
    }

}
