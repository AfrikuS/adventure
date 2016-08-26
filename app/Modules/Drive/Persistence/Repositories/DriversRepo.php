<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Drive\Domain\Entities\Driver;
use App\Modules\Drive\Persistence\Dao\DriversDao;
use App\Modules\Drive\Persistence\Dao\VehiclesDao;

class DriversRepo
{
    /** @var DriversDao */
    private $driversDao;

    /** @var VehiclesDao */
    private $vehiclesDao;

    public function __construct()
    {
        $this->driversDao = app('DriveDriversDao');
        $this->vehiclesDao = app('DriveVehiclesDao');
    }

    public function findById($user_id)
    {
        $driverData = $this->driversDao->find($user_id);
        
        $driver = new Driver($driverData);
        
        return $driver;
    }

    public function createDriver($user_id)
    {
        return $this->driversDao->createOnce($user_id);
    }

    public function createFirstVehicle($driver_id)
    {
        $this->vehiclesDao->createFirst($driver_id);
    }
}
