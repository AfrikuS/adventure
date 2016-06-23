<?php

namespace App\Http\Controllers\Geo;

use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\TravelRoute;
use App\Repositories\Geo\LocationsRepository;
use App\ViewModel\Geo\LocationsViewModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

// todo review -> add fsm
class TravelRouteController extends Controller
{
    public function buildRoute($id)
    {
        $locs = LocationsRepository::getLocationsWithNexts();

        $route = TravelRoute::with(['points' => function($query) {
            $query->select('location_id', 'status', 'number', 'route_id', 'id')
                ->with(['location' => function($query) {
                    $query->select('id', 'title');
                }]);
            }])
            ->select('id', 'title')
            ->find($id);

        $locationsTableRows = LocationsViewModel::geoBuildRoutePage($locs);
        
        $lastPoint = $route->points->last();

        $lastLocation = Location::with(['locationsTo' => function($query) {
            $query->select('geo_locations.title', 'geo_locations.id');
        }])
        ->select('id', 'title')
        ->find($lastPoint->location_id);

        $possibleLocationsSelect = $lastLocation->locationsTo->pluck('title', 'id');

        return $this->view('geo.routes_index', [
            'locations' => $locs,
            'route' => $route,
            'locationsTableRows'  => $locationsTableRows,
            'possibleLocationsSelect'  => $possibleLocationsSelect,
        ]);
    }

    public function addRoute()
    {
        $title = Input::get('title');
        $startLocation_id = Input::get('start_location_id');
        $user = \Auth::user();

        $route = GeoFactory::createRoute($user, $title, $startLocation_id);

        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }


    public function addRoutePoint()
    {
        $data = Input::all();
        $location_id = $data['location_id'];
        $route_id = $data['route_id'];

        $route = TravelRoute::with('points')->find($route_id);

        if ($route->status == 'commited') { // todo replace == 'forming'
            Session::flash('message', 'Route is commited yet!!!');
        }
        else {
            GeoFactory::createRoutePoint($route, $location_id); 
        }

        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }

    public function finalRoute()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        $route = TravelRoute::with('points')->find($route_id);

        if ($route->status == 'commited') {
            Session::flash('message', 'Route is commited yet!!!');
        }
        else {
            $lastPoint = $route->points->last();
            $lastPoint->update(['status' => 'final']);
        }
        
        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }

    public function deleteLastpoint()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        $route = TravelRoute::with('points')->find($route_id);

        if ($route->status == 'commited') {
            Session::flash('message', 'Route is commited yet!!!');
        }
        elseif ($route->points->count() < 2) {
            Session::flash('message', 'Route must include > 1 points!!!');
        }
        else {
            $route->points->last()->delete();
        }

        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }

}
