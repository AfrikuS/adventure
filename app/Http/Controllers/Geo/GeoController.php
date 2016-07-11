<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Geo\LocationsRepository;
use App\ViewData\Geo\LocationsViewData;

class GeoController extends Controller
{
    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

        $locationsTableRows = LocationsViewData::geoListLocationsPage($locations);
        
        return $this->view('geo.geo_index', [
            'locationsTableRows'  => $locationsTableRows,
        ]);
    }
}
