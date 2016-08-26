<?php

namespace App\Modules\Drive\Domain\Services;

use App\Exceptions\DetailNotFoundExeption;
use App\Modules\Drive\Domain\Commands\Garage\MountDetail;
use App\Modules\Drive\Domain\Commands\Garage\UnmountDetail;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;
use Illuminate\Support\Facades\Bus;

class GarageVehicleService
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
    }

    public function mountDetail($detail_id, $vehicle_id)
    {
        $vehicleDetail = $this->detailsRepo->findDetail($detail_id);


        
        $mountDetail = new MountDetail($detail_id, $vehicle_id);

        
        Bus::dispatch($mountDetail);
//        $vehicleDetail->mount($vehicle->id);

    }

    public function unmountDetail($detail_id)
    {


        $unmountDetail = new UnmountDetail($detail_id);


        Bus::dispatch($unmountDetail);

//        $vehicleDetail->unmount();
    }
}
