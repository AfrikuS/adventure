<?php

namespace App\Modules\Drive\Domain\Services;

use App\Modules\Drive\Domain\Commands\Vehicle\MountDetail;
use App\Modules\Drive\Domain\Commands\Vehicle\UnmountDetail;
use App\Modules\Drive\Persistence\Repositories\Vehicle\DetailsRepo;
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
        $mountDetail = new MountDetail($detail_id, $vehicle_id);

        
        Bus::dispatch($mountDetail);
    }

    public function unmountDetail($detail_id)
    {
        $unmountDetail = new UnmountDetail($detail_id);


        Bus::dispatch($unmountDetail);
    }
}
