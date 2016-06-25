<?php

namespace App\Http\Controllers\Geo\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Geo\TravelRoute;
use App\Models\Geo\Voyage;
use App\Repositories\Geo\LocationsRepository;
use App\Repositories\Geo\TravelRepository;
use App\Repositories\Geo\TravelRoutesRepository;
use App\Repositories\Geo\VoyagesRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class VoyageController extends Controller
{
    public function index()
    {
        $travelRoutes = TravelRoutesRepository::getRoutes();
        $voyages = VoyagesRepository::getVoyagesWithPointLocation();

        $locations = LocationsRepository::getLocationsWithNexts();
        $locationsSelect = $locations->pluck('title', 'id')->toArray();


        return $this->view('geo.business.business_index', [
            'voyages' => $voyages,
            'routes' => $travelRoutes,
            'locationsSelect'  => $locationsSelect,
        ]);
    }
    
    public function createVoyage()
    {
        $data = Input::all();
        $route_id = $data['route_id'];

        $route = TravelRoute::with('points')->find($route_id);
        
        $startPoint = $route->points->first();

        Voyage::create([
            'route_id' => $route_id,
            'point_id' => $startPoint->id,
            'status' => 'ready_to_sail', // in_cruise
        ]);

        return \Redirect::route('geo_map_page');
    }

    public function startSail()
    {
        $data = Input::all();
        $voyage_id = $data['voyage_id'];

        $voyage = VoyagesRepository::findById($voyage_id);

        if ($voyage->point->status == 'final') {
            Session::flash('message', 'Voyage is finished yet!!!');
        }
        elseif ($voyage->status == 'ready_to_sail') {
            $voyage->update(['status' => 'in_cruise']);
        }
        else {
            Session::flash('message', 'Ship in sea yet');
        }

        return \Redirect::back();
//        return \Redirect::route('geo_map_page');
    }

    public function moor() // причалить
    {
        $data = Input::all();
        $voyage_id = $data['voyage_id'];

        $voyage = VoyagesRepository::findById($voyage_id);
        $route = TravelRoutesRepository::findById($voyage->route_id);

        if ($voyage->point->status == 'final') {
            Session::flash('message', 'Voyage is finished yet!!!');
        }
        elseif ($voyage->status == 'in_cruise') {
            // change next point
            $currentPointNumber = $voyage->point->number;

            $nextPoint = $route->points->search(function ($item, $key) use ($currentPointNumber) {
                return $item->number == ($currentPointNumber + 1);
            });
            $nextPoint = $route->points->get($nextPoint);


            $voyage->update(['status' => 'ready_to_sail', 'point_id' => $nextPoint->id]);
        }
        else {
            Session::flash('message', 'Ship is ready to sail');
        }

        return \Redirect::back();
//        return \Redirect::route('geo_map_page');
    }
}
