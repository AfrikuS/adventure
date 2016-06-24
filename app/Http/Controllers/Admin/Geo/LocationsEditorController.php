<?php

namespace App\Http\Controllers\Admin\Geo;

use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Models\Geo\Location;
use App\Repositories\Geo\LocationsRepository;
use App\ViewModel\Geo\LocationsViewModel;
use Illuminate\Support\Facades\Input;

class LocationsEditorController extends Controller
{
    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

        $locationsTableRows = LocationsViewModel::geoListLocationsPage($locations);
        $locationsSelect = $locations->pluck('title', 'id')->toArray();

        return $this->view('admin.geo.locations', [
            'locationsTableRows'  => $locationsTableRows,
            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addLocation()
    {
        $title = Input::get('title');

        GeoFactory::createLocation($title);

        return \Redirect::route('admin_locations_page');
    }


    public function bind()
    {
        $location_id = Input::get('location_id');
        $nextLocation_id = Input::get('next_location_id');

        $location = Location::find($location_id);
        $location->locationsTo()->attach($nextLocation_id);

        return \Redirect::route('admin_locations_page');
    }

}
