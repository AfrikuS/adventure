<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Geo\Location;
use App\Models\Geo\TravelRoute;
use App\Repositories\Geo\LocationsRepository;
use App\Repositories\Geo\TravelRoutesRepository;
use App\Repositories\Geo\VoyagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\ViewModel\Geo\LocationsViewModel;

class LocationController extends Controller
{
    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();
        $routes = TravelRoutesRepository::getRoutes();
        $voyages = VoyagesRepository::getVoyagesWithPointLocation();

        $locationsTableRows = LocationsViewModel::geoListLocationsPage($locations);
        $locationsSelect = $locations->pluck('title', 'id')->toArray();
        
        return $this->view('geo.locations', [
            'locationsTableRows'  => $locationsTableRows,
            'routes'  => $routes,
            'voyages'  => $voyages,
            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addLocation()
    {
        $title = Input::get('title');

        Location::create($title);

        return \Redirect::route('geo_map_page');
    }


    public function bind()
    {
        $location_id = Input::get('location_id');
        $nextLocation_id = Input::get('next_location_id');

        $location = Location::find($location_id);
        $location->locationsTo()->attach($nextLocation_id);

        return \Redirect::route('geo_map_page');
    }
}
