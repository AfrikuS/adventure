<?php

namespace App\Modules\Geo\Http\Controllers\Harbour;

use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Geo\LiveVoyage;
use App\Modules\Geo\Actions\Cruise\SailToAction;
use App\Modules\Geo\Persistence\Repositories\Harbour\CruiseRepo;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Repositories\Geo\LocationsRepository;
use Illuminate\Support\Facades\Input;

class CruiseController extends Controller
{
    public function index()
    {
        /** @var LocationsRepo $locationsRepo */
        $locationsRepo = app('LocationsRepo');


        /** @var CruiseRepo $cruiseRepo */
        $cruiseRepo = app('CruiseRepo');
        
        $cruise = $cruiseRepo->findBy($this->user_id);


        $locationsColl = $locationsRepo->getLocationsWithNexts();
        $currentLocation = $locationsColl->find($cruise->location_id);



        $possibleLocationsSelect = $locationsColl->getNextsViewSelect($currentLocation->id);



        return $this->view('geo.business.cruise.voyages_index', [
            'cruise' => $cruise,
            'currentLocation' => $currentLocation,
            'possibleLocationsSelect'  => $possibleLocationsSelect,
        ]);
    }

    public function sailTo()
    {
        $nexLocation_id = Input::get('next_id');
        $user_id = \Auth::id();

        
        $action = new SailToAction();
        
        $action->sailTo($nexLocation_id, $user_id);
        

        return \Redirect::route('geo_live_voyage_page');
    }
}
