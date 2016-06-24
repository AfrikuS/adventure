<?php

namespace App\Http\Controllers\Geo;

use App\Repositories\Geo\LocationsRepository;
use App\ViewModel\Geo\LocationsViewModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
