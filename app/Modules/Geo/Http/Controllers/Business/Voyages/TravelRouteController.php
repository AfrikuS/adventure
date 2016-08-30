<?php

namespace App\Modules\Geo\Http\Controllers\Business\Voyages;

use App\Exceptions\Commands\Geo\OneRoutePointException;
use App\Exceptions\Commands\Geo\RouteCommitedException;
use App\Http\Controllers\Controller;
use App\Modules\Geo\Actions\Business\AddRoutePointCommand;
use App\Modules\Geo\Actions\Business\CommitRouteCommand;
use App\Modules\Geo\Actions\Business\CreateRouteTravelCommand;
use App\Modules\Geo\Actions\Business\DeleteLastRoutePointCommand;
use App\Modules\Geo\Actions\Business\UncommitRouteCommand;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TravelRouteController extends Controller
{
    /** @var TravelRoutesRepo */
    protected $travelRoutesRepo;

    /** @var LocationsRepo */
    private $locationsRepo;


    public function __construct()
    {
        parent::__construct();

        $this->travelRoutesRepo = app('TravelRoutesRepo');

        $this->locationsRepo = app('LocationsRepo');
    }
    
    public function editRoute($id)
    {
        $locs = $this->locationsRepo->getLocationsWithNexts();


        $route = $this->travelRoutesRepo->find($id);


        $lastPoint = last($route->points);

        $potentialLocations = $locs->getNextsViewSelect($lastPoint->location_id);

        return $this->view('geo.business.voyages.routes_index', [
            'locations' => $locs,
            'route' => $route,
            'potentialLocations'  => $potentialLocations,
        ]);
    }

    public function createRoute()
    {
        $title = Input::get('title');
        $startLocation_id = Input::get('start_location_id');


        $cmd = new CreateRouteTravelCommand();

        $route_id = $cmd->createRoute(
            $this->user_id,
            $title,
            $startLocation_id
        );
        
        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }


    public function addRoutePoint()
    {
        $data = Input::all();
        $location_id = $data['location_id'];
        $route_id = $data['route_id'];

        try {

            $cmd = new AddRoutePointCommand();
            
            $cmd->addRoutePont($route_id, $location_id);

        }
        catch (StateException $e)
        {
            Session::flash('message', 'Route is commited yet!!!');

            return \Redirect::back();
        }

        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

    public function commitRoute()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        try {
            $cmd = new CommitRouteCommand($this->travelRoutesRepo);

            $cmd->commitRoute($route_id);
        }
        catch (RouteCommitedException $e)
        {
            Session::flash('message', 'Route is commited yet!!!');
            return \Redirect::back();
        }
        
        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

    public function uncommitRoute()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        try {
            $cmd = new UncommitRouteCommand();

            $cmd->uncommit($route_id);
        }
        catch (StateException $e)
        {
            Session::flash('message', 'Cannot operation');
            return \Redirect::back();
        }

        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

    public function deleteLastpoint()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        try {
            $cmd = new DeleteLastRoutePointCommand($this->travelRoutesRepo);

            $cmd->deleteLastPointFromRoute($route_id);
        }
        catch (StateException $e)
        {

            Session::flash('message', 'Cannot operation');
            return \Redirect::back();
        }

        return \Redirect::route('geo_route_build_page', ['id' => $route_id]);
    }

}
