<?php

namespace App\Http\Controllers\Admin\Geo;

use App\Commands\Geo\BindLocationsCommand;
use App\Commands\Geo\CreateLocationCommand;
use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Models\Geo\Location;
use App\Repositories\Geo\LocationsRepository;
use App\ViewData\Geo\LocationsViewData;
use Illuminate\Support\Facades\Input;

class LocationsEditorController extends Controller
{
    /** @var LocationsRepository */
    private $locationsRepo;

    public function __construct(LocationsRepository $locationsRepo)
    {
        $this->locationsRepo = $locationsRepo;
        
        parent::__construct();
    }

    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

        $locationsTableRows = LocationsViewData::geoListLocationsPage($locations);
        $locationsSelect = $locations->pluck('title', 'id')->toArray();

        return $this->view('admin.geo.locations', [
            'locationsTableRows'  => $locationsTableRows,
            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addLocation()
    {
        $title = Input::get('title');

        $cmd = new CreateLocationCommand($this->locationsRepo);
        $cmd->createLocation($title);
        
        return \Redirect::route('admin_locations_page');
    }


    public function bind()
    {
        $location_id = Input::get('location_id');
        $nextLocation_id = Input::get('next_location_id');

        $cmd = new BindLocationsCommand($this->locationsRepo);
        
        $cmd->bindLocations($location_id, $nextLocation_id);
            

        return \Redirect::route('admin_locations_page');
    }

}
