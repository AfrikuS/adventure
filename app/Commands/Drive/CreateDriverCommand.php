<?php

namespace App\Commands\Drive;

use App\Repositories\Drive\DriverRepository;
use App\Repositories\Drive\VehicleRepository;

class CreateDriverCommand
{
    /** @var DriverRepository */
    private $driverRepo;
    /** @var VehicleRepository */
    private $vehicleRepo;

    public function __construct(DriverRepository $driverRepo)
    {
        $this->driverRepo = $driverRepo;
    }

    public function createDriver($user_id)
    {
        \DB::beginTransaction();
        try {

            $driver = $this->driverRepo->findById($user_id);
            
            if (null == $driver) {

                $driver = $this->driverRepo->createDriver($user_id);
            }

            $vehicle = $this->vehicleRepo->findSimpleVehicleByDriverId($driver->id);
            
            if (null == $vehicle) {

                $vehicle = $this->driverRepo->createFirstVehicle($driver->id);
            }
            

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
