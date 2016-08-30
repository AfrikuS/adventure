<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Persistence\Dao\VehiclesDao;
use App\Modules\Drive\Persistence\Repositories\Vehicle\DetailsRepo;

class VehiclesRepo
{
    /** @var DetailsRepo */
    private $detailsRepo;
    
    /** @var VehiclesDao */
    private $vehiclesDao;
    
    /** @var DriversRepo */
    private $driversRepo;

    public function __construct(DetailsRepo $detailsRepo, VehiclesDao $vehicles)
    {
        $this->detailsRepo = $detailsRepo;
        $this->vehiclesDao = $vehicles;
        $this->driversRepo = app('DriveDriversRepo');
    }

    public function findActiveByDriver($driver_id)
    {
        $driver = $this->driversRepo->findById($driver_id);
        
        $vehicle = $this->find($driver->vehicle_id);

        return $vehicle;
    }

    public function find($vehicle_id)
    {
        $vehicle = EntityStore::get(Vehicle::class, $vehicle_id);

        if (null !== $vehicle) {
            return $vehicle;
        }

        $vehicleData = $this->vehiclesDao->find($vehicle_id);

        $vehicle = new Vehicle($vehicleData);

        EntityStore::add($vehicle, $vehicle->id);

        return $vehicle;
    }

    /** @deprecated  */
    public function findViewVehicle($driver_id)
    {
        $vehicleData = $this->vehiclesDao->findViewVehicle($driver_id);

        return $vehicleData;
    }

    public function updateRepairData(Vehicle $vehicle)
    {
        $this->vehiclesDao->updateRepair(
            $vehicle->id,
            $vehicle->status,
            $vehicle->damage_percent,
            $vehicle->fuel_level
        );
    }
}
