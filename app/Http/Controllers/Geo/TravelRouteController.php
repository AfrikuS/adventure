<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\TravelRoute;
use Illuminate\Support\Facades\Input;

class TravelRouteController extends Controller
{
 /*   public function index()
    {
        $locs = Location::with('locationsTo')->get();

        $locsView = [];

        foreach ($locs as $loc) {

            $locationsTo = $loc->locationsTo;
//            $locationsToArr = [];
//            foreach ($locationsTo as $loc1) {
//                $locationsToArr[] = $loc1->pivot->to_id;
//            }

            $nextLocationsTitles = $loc->locationsTo()->lists('title')->toArray();


            $data = [
                'title' => $loc->title,
//                'next_ids' => $locationsToArr,
                'next_locations_title' => $nextLocationsTitles,
            ];
            $locsView[$loc->id] = $data;
        }

        $routes = TravelRoute::with('points')->get();

        $routePoints = $routes->first()->points;
        $lastPoint = $routePoints->last();
        $possibleLocationsSelect = Location::get(['id', 'title'])->pluck('title', 'id');

        if ($lastPoint != null) {

            $lastLocation = Location::with('locationsTo')->find($lastPoint->location_id);

            $possibleLocationsSelect = $lastLocation->locationsTo()->get()->pluck('title', 'id');

        }


        $locationsSelect = Location::get()->pluck('title', 'id')->toArray();



        return $this->view('geo.routes_index', [
            'locations' => $locs,
            'locsView'  => $locsView,
            'routes'  => $routes,
            'routePoints'  => $routePoints,
            'possibleLocationsSelect'  => $possibleLocationsSelect,
            'locationsSelect'  => $locationsSelect,
        ]);

    }*/

    public function buildRoute($id)
    {
        $locs = Location::with('locationsTo')->get();
        $route = TravelRoute::find($id);

        $locsView = [];

        foreach ($locs as $loc) {

            $nextLocationsTitles = $loc->locationsTo()->lists('title')->toArray();


            $data = [
                'title' => $loc->title,
                'next_locations_title' => $nextLocationsTitles,
            ];
            $locsView[$loc->id] = $data;
        }

        $routes = TravelRoute::with('points')->get();

        $routePoints = $routes->first()->points;
        $lastPoint = $routePoints->last();
        $possibleLocationsSelect = Location::get(['id', 'title'])->pluck('title', 'id');

        if ($lastPoint != null) {

            $lastLocation = Location::with('locationsTo')->find($lastPoint->location_id);

            $possibleLocationsSelect = $lastLocation->locationsTo()->get()->pluck('title', 'id');

        }


        $locationsSelect = Location::get()->pluck('title', 'id')->toArray();



        return $this->view('geo.routes_index', [
            'locations' => $locs,
            'route' => $route,
            'locsView'  => $locsView,
            'routes'  => $routes,
            'routePoints'  => $routePoints,
            'possibleLocationsSelect'  => $possibleLocationsSelect,
            'locationsSelect'  => $locationsSelect,
        ]);
    }

    public function addRoute()
    {
        $title = Input::get('title');
        $user_id = \Auth::id();

        $route = TravelRoute::create([
            'title' => $title,
            'user_id' => $user_id,
        ]);

        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }


    public function addRoutePoint()
    {
        $data = Input::all();
        $location_id = $data['location_id'];
        $route_id = $data['route_id'];

        $route = TravelRoute::with('points')->find($route_id);
        $pointsCount = $route->points->count();


        RoutePoint::create([
            'route_id' => $route_id,
            'location_id' => $location_id,
            'status' => 'normal',
            'number' => $pointsCount + 1,
        ]);

        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }

    public function deleteLastpoint()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        $route = TravelRoute::with('points')->find($route_id);
//        $pointsCount = $route->points->count();
        $route->points->last()->delete();


        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }

}
