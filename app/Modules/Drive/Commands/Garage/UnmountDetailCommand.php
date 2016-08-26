<?php

namespace App\Modules\Drive\Commands\Garage;

use App\Exceptions\DetailNotFoundExeption;
use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Models\Drive\Vehicle;
use App\Modules\Drive\Domain\Services\GarageVehicleService;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;
use App\Repositories\Drive\DetailRepository;

class UnmountDetailCommand
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
    }

    public function unmountDetail($detail_id, $driver_id)
    {
        $this->validateCommand($detail_id, $driver_id);


        $vehicleService = new GarageVehicleService();

        $vehicleService->unmountDetail($detail_id);
    }

    public function validateCommand($detail_id, $driver_id)
    {
        $detail = $this->detailsRepo->findDetail($detail_id);


        if ($detail->owner_driver_id != $driver_id) {

            throw new EntityNotFound_Exception;
        }
    }

}
