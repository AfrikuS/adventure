<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Persistence\Repositories\Vehicle\DetailsRepo;

// as bounded context
class GarageRepo
{
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    /** @var DriversRepo */
    private $driversRepo;

    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct(VehiclesRepo $vehiclesRepo, DriversRepo $driversRepo, DetailsRepo $detailsRepo)
    {
        $this->vehiclesRepo = app('DriveVehiclesRepo');
        $this->driversRepo  = app('DriveDriversRepo');
        $this->detailsRepo  = app('DriveDetailsRepo');
    }

    public function findVehicleWithDetailsByDriver($driver_id)
    {
        /** @var Vehicle $vehicle */
        $vehicle = $this->vehiclesRepo->findBy($driver_id);

        $details = $this->detailsRepo->getBy($vehicle->id);

        $vehicle->setDetails($details); // review vehicle details in entitystore


        return $vehicle;
    }


}
