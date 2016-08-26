<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Infrastructure\IdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Garage\RepairVehicle;
use App\Modules\Drive\Domain\Entities\Raid\RobberyVehicle;
use App\Modules\Drive\Persistence\Dao\DetailsDao;
use App\Modules\Drive\Persistence\Dao\VehiclesDao;

class VehiclesRepo
{
    /** @var DetailsDao */
    private $detailsDao;
    
    /** @var VehiclesDao */
    private $vehiclesDao;

    public function __construct(DetailsDao $details, VehiclesDao $vehicles)
    {
        $this->detailsDao = $details; // app('DriveDetailsDao');
        $this->vehiclesDao = $vehicles; // app('DriveVehiclesDao');
    }

    public function findActiveByDriver($driver_id)
    {
        $vehicleData = $this->vehiclesDao->findActiveVehicle($driver_id);
        
        return $vehicleData;
    }

    public function findViewVehicle($driver_id)
    {
        $vehicleData = $this->vehiclesDao->findViewVehicle($driver_id);

        return $vehicleData;
    }

    public function findRepairVehicle($id)
    {
        $vehicle = EntityStore::get(RepairVehicle::class, $id);
        
        if (null != $vehicle) {
            
            return $vehicle;
        }
        
        $vehicleData = $this->vehiclesDao->findVehicleForRepair($id);
        
        $vehicle = new RepairVehicle($vehicleData);

        EntityStore::add($vehicle, $vehicle->id);
        
        return $vehicle;
    }

    public function findRobberyVehicle($vehicle_id)
    {
        $vehicle = EntityStore::get(RobberyVehicle::class, $vehicle_id);
            
        if (null != $vehicle) {

            return $vehicle;
        }

        $vehicleData = $this->vehiclesDao->findRobberyVehicle($vehicle_id);

        $vehicle = new RobberyVehicle($vehicleData);

        EntityStore::add($vehicle, $vehicle->id);

        return $vehicle;
    }
    
    public function getMountedDetails($vehicle_id)
    {
        $details = $this->detailsDao->getMountedByVehicle($vehicle_id);
        
        return $details;
    }

    public function updateRepairData(RepairVehicle $vehicle)
    {
        $this->vehiclesDao->updateRepair(
            $vehicle->id,
            $vehicle->status,
            $vehicle->damage_percent,
            $vehicle->fuel_level
        );
    }
}
