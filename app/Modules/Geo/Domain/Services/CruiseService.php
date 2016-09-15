<?php

namespace App\Modules\Geo\Domain\Services;

use App\Modules\Geo\Domain\Entities\Harbour\Cruise;
use App\Modules\Geo\Persistence\Repositories\Harbour\CruiseRepo;

class CruiseService
{
    /** @var CruiseRepo */
    private $cruiseRepo;

    public function __construct()
    {
        $this->cruiseRepo = app('CruiseRepo');
    }


    public function sailTo(Cruise $cruise, $nextLocation_id)
    {
        $cruiseRepo = app('CruiseRepo');
        
        $cruiseRepo->update($cruise, $nextLocation_id, Cruise::STATUS_READY_SAIL);
    }
}
