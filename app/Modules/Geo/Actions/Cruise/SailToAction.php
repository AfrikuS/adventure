<?php

namespace App\Modules\Geo\Actions\Cruise;

use App\Modules\Geo\Domain\Entities\Harbour\Cruise;
use App\Modules\Geo\Domain\Entities\Location;
use App\Modules\Geo\Domain\Services\CruiseService;
use App\Modules\Geo\Persistence\Catalogs\LocationsCollection;
use App\Modules\Geo\Persistence\Repositories\Harbour\CruiseRepo;
use Finite\Exception\StateException;

class SailToAction
{
    /** @var CruiseRepo */
    private $cruiseRepo;

    public function __construct()
    {
        $this->cruiseRepo = app('CruiseRepo');
    }

    public function sailTo($nextLocation_id, $user_id)
    {
        $cruise = $this->cruiseRepo->findBy($user_id);



        $this->validateAction($cruise, $nextLocation_id);



        $cruiseService = new CruiseService();



        $cruiseService->sailTo($cruise, $nextLocation_id);
    }

    private function validateAction(Cruise $cruise, $next_id)
    {
        $locationsRepo = app('LocationsRepo');

        /** @var LocationsCollection $mapWorld */
        $mapWorld = $locationsRepo->getLocationsWithNexts();

        /** @var Location $currLocation */
        $currLocation = $mapWorld->find($cruise->location_id);

        if (! $currLocation->isExistNextLocation($next_id)) {
            throw new StateException;
        }
    }
}
