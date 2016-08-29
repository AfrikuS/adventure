<?php

namespace App\Modules\Geo\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Geo\Actions\BindLocationsCommand;
use App\Modules\Geo\Actions\CreateLocationCommand;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\View\Models\PotentialNextLocations;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;

class LocationsEditorController extends Controller
{
    /** @var LocationsRepo */
    private $locationsRepo;

    public function __construct(LocationsRepo $locationsRepo)
    {
        $this->locationsRepo = $locationsRepo;
        
        parent::__construct();
    }

    public function index()
    {
        $locationsColl = $this->locationsRepo->getLocationsWithNexts();

//        $locationsTableRows = LocationsViewData::geoListLocationsPage($locationsColl);
        
        $locationsSelect = $locationsColl->getViewSelect(); //pluck('title', 'id')->toArray();


        $potentialsLocationsColl = new PotentialNextLocations();

        foreach ($locationsColl->locations as $location) {

            $potentials = $locationsColl->getPotentialNexts($location->id);
            $potentialsLocationsColl->add($location->id, $potentials);
        }

        return $this->view('admin.geo.locations', [
            'locationsColl'  => $locationsColl->locations,
            'potentialsMap'  => $potentialsLocationsColl,
            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addLocation()
    {
        $title = Input::get('title');

        $cmd = new CreateLocationCommand();
        
        $cmd->createLocation($title);
        
        return \Redirect::route('admin_locations_page');
    }


    public function bind()
    {
        $location_id = Input::get('location_id');
        $nextLocation_id = Input::get('next_location_id');

        $cmd = new BindLocationsCommand();
        
        try {

            $cmd->bindLocations($location_id, $nextLocation_id);
        }
        catch (StateException $e) {
            
            \Session::flash('message', 'Locations are bounded yet');
        }    

        return \Redirect::route('admin_locations_page');
    }

}
