<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Driver;
use App\Modules\Drive\Persistence\Dao\DriversDao;
use App\Modules\Drive\Persistence\Dao\VehiclesDao;

class DriversRepo
{
    /** @var DriversDao */
    private $driversDao;

    /** @var VehiclesDao */
    private $vehiclesDao;

    public function __construct(DriversDao $driversDao, VehiclesDao $vehiclesDao)
    {
        $this->driversDao = $driversDao;
        $this->vehiclesDao = $vehiclesDao;
    }

    public function findById($user_id)
    {
        $driver = EntityStore::get(Driver::class, $user_id);
        
        if (null !== $driver) {
            return $driver;
        }

        $driverData = $this->driversDao->find($user_id);
        
        $driver = new Driver($driverData);
        
        EntityStore::add($driver, $driver->id);
        
        return $driver;
    }

    public function createDriver($user_id)
    {
        return $this->driversDao->createOnce($user_id);
    }

    /** @deprecated  */
    public function createFirstVehicle($driver_id)
    {
        $this->vehiclesDao->createFirst($driver_id);
    }

    public function updateStatus(Driver $driver)
    {
        $this->driversDao->update(
            $driver->id, 
            $driver->status
        );
    }
}
