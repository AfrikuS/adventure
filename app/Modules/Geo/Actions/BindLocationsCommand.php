<?php

namespace App\Modules\Geo\Actions;

use App\Modules\Geo\Domain\Entities\Location;
use App\Modules\Geo\Domain\Services\LocationsService;
use App\Modules\Geo\Persistence\Catalogs\LocationsCollection;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use Finite\Exception\StateException;

class BindLocationsCommand
{
    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct()
    {
        $this->locationsRepo = app('LocationsRepo');
    }

    public function bindLocations($location_id, $nextLocation_id)
    {
        $locationsCollection = $this->locationsRepo->getLocationsWithNexts();


//        /** @var Location $location */
//        $location = $this->locationsRepo->findById($location_id);
//        /** @var Location $location */
//        $nextLocation = $this->locationsRepo->findById($nextLocation_id);

        $this->validateAction($locationsCollection, $location_id, $nextLocation_id);

        $locationsService = new LocationsService();
        
        \DB::beginTransaction();
        try {

//            $location->addNextLocation($nextLocation->id);

            $locationsService->bindLocations($location_id, $nextLocation_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
        
    }

    private function validateAction(LocationsCollection $locationsCollection, $from_id, $to_id)
    {
        /** @var Location $locationFrom */
        $locationFrom = $locationsCollection->find($from_id);

        array_key_exists($to_id, $locationFrom->nextLocations);
        if ($locationFrom->isExistNextLocation($to_id)) {

            throw new StateException;
        }
    }
}
