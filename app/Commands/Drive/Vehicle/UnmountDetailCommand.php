<?php

namespace App\Commands\Drive\Vehicle;

use App\Exceptions\DetailNotFoundExeption;
use App\Models\Drive\Vehicle;
use App\Repositories\Drive\DetailRepository;

class UnmountDetailCommand
{
    /** @var DetailRepository */
    private $detailRepo;

    public function __construct(DetailRepository $detailRepo)
    {
        $this->detailRepo = $detailRepo;
    }

    public function unmountDetail($detail_id, Vehicle $vehicle)
    {
        $vehicleDetail = $this->detailRepo->getVehicleDetailById($detail_id);
        
        if ($vehicleDetail == null || $vehicleDetail->owner_driver_id != $vehicle->driver_id) {
            
            throw new DetailNotFoundExeption;
        }


        $vehicleDetail->unmount();
    }
}