<?php

namespace App\Commands\Geo;

use App\Models\Geo\Location;
use App\Repositories\Geo\LocationsRepository;

class BindLocationsCommand
{
    /** @var LocationsRepository */
    private $locationsRepo;

    public function __construct(LocationsRepository $locationsRepo)
    {
        $this->locationsRepo = $locationsRepo;
    }

    public function bindLocations($location_id, $nextLocation_id)
    {
        /** @var Location $location */
        $location = $this->locationsRepo->findById($location_id);
        /** @var Location $location */
        $nextLocation = $this->locationsRepo->findById($nextLocation_id);

        
        \DB::beginTransaction();
        try {

            $location->addNextLocation($nextLocation->id);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
        
    }
}
