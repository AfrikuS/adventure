<?php

namespace App\Modules\Drive\Domain\Handlers\Garage;

use App\Modules\Drive\Domain\Commands\Garage\UnmountDetail;
use App\Modules\Drive\Domain\Entities\Garage\Detail;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;

class UnmountDetailHandler
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
    }

    public function handle(UnmountDetail $command)
    {
        /** @var Detail $detail */
        $detail = $this->detailsRepo->getVehicleDetailForUnmount($command->detail_id);
//        $vehicleDetail = $this->detailsRepo->getVehicleDetailForUnmount($detail_id);

        
        $detail->unmount();


        $this->detailsRepo->updateMountStatus($detail);
    }
}
