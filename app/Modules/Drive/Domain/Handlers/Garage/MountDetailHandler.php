<?php

namespace App\Modules\Drive\Domain\Handlers\Garage;

use App\Modules\Drive\Domain\Commands\Garage\MountDetail;
use App\Modules\Drive\Persistence\Dao\DetailsDao;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;

class MountDetailHandler
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
    }

    public function handle(MountDetail $command)
    {

        // validate mouned detail - in dao
        $detail = $this->detailsRepo->findDetail($command->detail_id);

        $detail->mountOn($command->vehicle_id);


        $this->detailsRepo->updateMountStatus($detail);
    }
}
