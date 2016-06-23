<?php

namespace App\Http\Controllers\Geo;

use App\Models\Geo\LiveVoyage;
use App\Repositories\Geo\LocationsRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LiveVoyageController extends Controller
{
    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

//        $liveVoyages = LiveVoyage::get();
        $user_id = \Auth::id();

        $voyage = LiveVoyage::select('id', 'location_id', 'status', 'traveler_id')
            ->where('traveler_id', $user_id)
            ->with(['location' => function ($query) {
                $query->select('id', 'title')
                ->with(['locationsTo' => function ($query) {
                    $query->select('geo_locations.title', 'geo_locations.id');
                }]);
            }])
            ->first();

        if ($voyage == null) {
            $voyage = LiveVoyage::create([
                'location_id' => 6,
                'traveler_id' => $user_id,
                'status' => 'ready_to_sail',
            ]);
        }

        $currentLocation = $voyage->location;
        
        $possibleLocationsSelect = $voyage->location->locationsTo->pluck('title', 'id')->toArray();



        return $this->view('geo.live_voyage.voyages_index', [
            'locations' => $locations,
            'voyage' => $voyage,
            'currentLocation' => $currentLocation,
            'possibleLocationsSelect'  => $possibleLocationsSelect,
        ]);
    }

    public function sailTo()
    {
        $nexLocation_id = Input::get('next_id');
        $user_id = \Auth::id();

        $voyage = LiveVoyage::where('traveler_id', $user_id)->first();

        $voyage->update(['location_id' => $nexLocation_id]);
//        $route = TravelRoute::create([
//            'title' => $title,
//            'user_id' => $user_id,
//        ]);

        return \Redirect::route('geo_live_voyage_page');

    }
}
