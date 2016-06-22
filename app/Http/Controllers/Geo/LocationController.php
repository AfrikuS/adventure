<?php

namespace App\Http\Controllers\Geo;

use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\TravelRoute;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LocationController extends Controller
{
    public function index()
    {
        $locs = Location::with('locationsTo')->get();

        $locsView = [];
        
        foreach ($locs as $loc) {

            $locationsTo = $loc->locationsTo;
            $locationsToArr = [];
            foreach ($locationsTo as $loc1) {
                $locationsToArr[] = $loc1->pivot->to_id;
            }

//            $locationsSelect = $locs->filter(function ($location) use($loc) {
//                $currLoc = $loc;
//                return $location->id != $currLoc && !$currLoc->locationsTo->search($location);
//            })-> pluck('title', 'id');

            $locationsSelect = Location::where('id', '<>', $loc->id)
                ->whereNotIn('id', $locationsToArr)
                ->get()->pluck('title', 'id');
            
            $nextLocationsTitles = $loc->locationsTo()->lists('title')->toArray();
                
                
            $data = [
                'title' => $loc->title,
                'next_ids' => $locationsToArr,
                'next_locations_title' => $nextLocationsTitles,
                'locs_select' => $locationsSelect,
            ];
            $locsView[$loc->id] = $data;
        }

        $routes = TravelRoute::with('points')->get();

        $routePoints = $routes->first()->points;
        $lastPoint = $routePoints->last();
        $possibleLocationsSelect = Location::get()->pluck('title', 'id');

        if ($lastPoint != null) {

            $lastLocation = Location::with('locationsTo')->find($lastPoint->location_id);

            $possibleLocationsSelect = $lastLocation->locationsTo()->get()->pluck('title', 'id');

        }



        $locationsSelect = Location::get()->pluck('title', 'id')->toArray();


        
        return $this->view('geo.locations', [
            'locations' => $locs,
            'locsView'  => $locsView,
            'routes'  => $routes,
            'routePoints'  => $routePoints,
            'possibleLocationsSelect'  => $possibleLocationsSelect,
            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addLocation()
    {
        $title = Input::get('title');

        Location::create([
            'title' => $title,
        ]);

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


    /** @deprecated  node */
    public function show(Request $request, $location_id)
    {
        $location = Location::find($location_id);

        $locationsTo = $location->locationsTo;
        $locationsToArr = [];
        foreach ($locationsTo as $loc) {
            $locationsToArr[] = $loc->pivot->to_id;
        }
        $locationsSelect = Location::where('id', '<>', $location_id)
            ->whereNotIn('id', $locationsToArr)
            ->get()->pluck('title', 'id');

        return $this->view('geo.location_show', [
            'currLocation' => $location,
            'locationsTo' => $locationsTo,
            'locationsSelect' => $locationsSelect,
        ]);
    }
}
