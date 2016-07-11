<?php

namespace App\Http\Controllers\Geo;

use App\Commands\Geo\Business\AddRoutePointCommand;
use App\Commands\Geo\Business\CommitRouteCommand;
use App\Commands\Geo\Business\CreateRouteTravelCommand;
use App\Commands\Geo\Business\DeleteLastRoutePointCommand;
use App\Exceptions\Commands\Geo\OneRoutePointException;
use App\Exceptions\Commands\Geo\RouteCommitedException;
use App\Factories\Geo\RouteTravelFactory;
use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Models\Geo\Location;
use App\Models\Geo\RoutePoint;
use App\Models\Geo\TravelRoute;
use App\Repositories\Geo\LocationsRepository;
use App\Repositories\Geo\RouteTravelRepositoryObj;
use App\Repositories\Geo\TravelRoutesRepository;
use App\ViewData\Geo\LocationsViewData;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TravelRouteController extends Controller
{
    /** @var RouteTravelRepositoryObj */
    protected $routeRep;

    public function __construct(RouteTravelRepositoryObj $routeRep)
    {
        $this->routeRep = $routeRep;
        parent::__construct();
    }
    
    public function editRoute($id)
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

        $locationsTableRows = LocationsViewData::geoBuildRoutePage($locs);
        
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

    public function createRoute()
    {
        $title = Input::get('title');
        $startLocation_id = Input::get('start_location_id');
        $user_id = \Auth::id();

        $cmd = new CreateRouteTravelCommand();
        
        $route = $cmd->createRoute($user_id, $title, $startLocation_id);

        return \Redirect::route('geo_route_build_page', ['id' => $route->id]);
    }


    public function addRoutePoint()
    {
        $data = Input::all();
        $location_id = $data['location_id'];
        $route_id = $data['route_id'];

        try {
            $cmd = new AddRoutePointCommand($this->routeRep, new RouteTravelFactory());
            
            $cmd->addRoutePont($route_id, $location_id);
        }
        catch (RouteCommitedException $e)
        {
            Session::flash('message', 'Route is commited yet!!!');
            return \Redirect::back();
        }

        Session::flash('message', 'Route point added!!!');
        
        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

    public function commitRoute()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        try {
            $cmd = new CommitRouteCommand($this->routeRep);

            $cmd->commitRoute($route_id);
        }
        catch (RouteCommitedException $e)
        {
            Session::flash('message', 'Route is commited yet!!!');
            return \Redirect::back();
        }
        
        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

    public function deleteLastpoint()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        try {
            $cmd = new DeleteLastRoutePointCommand($this->routeRep);

            $cmd->deleteLastPointFromRoute($route_id);
        }
        catch (OneRoutePointException $e)
        {
            Session::flash('message', 'Route must include > 1 points!!!');
            return \Redirect::back();
        }
        catch (RouteCommitedException $e)
        {
            Session::flash('message', 'Route commited yet');
            return \Redirect::back();
        }

        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

}
