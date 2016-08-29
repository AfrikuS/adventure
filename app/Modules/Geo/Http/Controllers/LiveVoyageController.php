<?php

namespace App\Modules\Geo\Http\Controllers;

use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Geo\LiveVoyage;
use App\Repositories\Geo\LocationsRepository;
use Illuminate\Support\Facades\Input;

class LiveVoyageController extends Controller
{
    public function index()
    {
        $locations = LocationsRepository::getLocationsWithNexts();

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
            GeoFactory::createLiveVoyage(6, $user_id);
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
