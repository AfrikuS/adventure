<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Geo\LocationsRepository;
use App\ViewModel\Geo\LocationsViewModel;

class GeoController extends Controller
{
    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

        $locationsTableRows = LocationsViewModel::geoListLocationsPage($locations);
        
        return $this->view('geo.geo_index', [
            'locationsTableRows'  => $locationsTableRows,
        ]);
    }
}
