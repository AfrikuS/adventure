<?php

namespace App\Modules\Geo\Http\Controllers\Harbour;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Repositories\Geo\LocationsRepository;
use App\ViewData\Geo\LocationsViewData;

class HarbourController extends Controller
{
    public function index()
    {
//        /** @var LocationsRepo $locationsRepo */
//        $locationsRepo = app('LocationsRepo');
//        $locationsCollection = $locationsRepo->getLocationsWithNexts();

//        $locationsTableRows = $locationsRepo->geoListLocationsPage($locations);
//        $locationsCollection = $locations;

        return $this->view('geo.geo_index', [
//            'locationsCollection'  => $locationsCollection->locations,
//            'locationsTableRows'  => $locationsTableRows,
        ]);
    }
}
