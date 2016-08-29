<?php

namespace App\Modules\Geo\Domain\Services;

use App\Modules\Geo\Persistence\Repositories\LocationsRepo;

class LocationsService
{
    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct()
    {
        $this->locationsRepo = app('LocationsRepo');
    }

    public function bindLocations($from_id, $to_id)
    {
        $this->locationsRepo->bindLocations($from_id, $to_id);
    }
}
