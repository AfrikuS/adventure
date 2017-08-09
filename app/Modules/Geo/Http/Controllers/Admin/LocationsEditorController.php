<?php

namespace App\Modules\Geo\Http\Controllers\Admin;

use App\Modules\Core\Http\Controller;
use App\Modules\Geo\Actions\BindLocationsCommand;
use App\Modules\Geo\Actions\CreateLocationCommand;
use App\Modules\Geo\Actions\RemovePathAction;
use App\Modules\Geo\Persistence\Dao\LocationsDao;
use App\Modules\Geo\Persistence\Dao\Redis\RedisLocationsRelationsDao;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\View\Models\PotentialNextLocations;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;
use Redis;

class LocationsEditorController extends Controller
{

    public function index()
    {
        /** @var LocationsRepo $locationsRepo */
        $locationsRepo = app('LocationsRepo');

        $locationsColl = $locationsRepo->getLocationsWithNexts();


        $locationsSelect = $locationsColl->getViewSelect();


        $potentialsLocationsColl = new PotentialNextLocations();

        foreach ($locationsColl->locations as $location) {

            $potentials = $locationsColl->getPotentialNexts($location->id);
            $potentialsLocationsColl->add($location->id, $potentials);
        }

        return $this->view('geo.admin.locations', [
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

    public function removePath($from_id, $to_id)
    {
        $cmd = new RemovePathAction();

        try {

            $cmd->removePath($from_id, $to_id);
        }
        catch (StateException $e) {

            \Session::flash('message', 'Locations aren\'t bounded');
        }

        return \Redirect::route('admin_locations_page');
    }

    public function fillRedisData()
    {
        $data = Input::all();


        $locationsDao = new LocationsDao();
        $locations = $locationsDao->getLocations();

        $locationsRels = [];
        foreach ($locations as $location) {

            $next_ids = $locationsDao->getNextIdsBy($location->id);
            $locationsRels[$location->id] = $next_ids;
        }

        // move data to redis

        $redisLocationsDao = new RedisLocationsRelationsDao();

        foreach ($locationsRels as $locationId => $nextArr) {

            foreach ($nextArr as $next_id) {

                $redisLocationsDao->addByLocation($locationId, $next_id);
            }
        }


        return \Redirect::route('admin_locations_page');
    }
}
