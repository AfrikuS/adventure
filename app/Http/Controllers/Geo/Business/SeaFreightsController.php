<?php

namespace App\Http\Controllers\Geo\Business;

use App\Http\Controllers\Controller;
use App\Models\Geo\Trader\Ship;
use App\Repositories\Geo\LocationsRepository;
use App\Repositories\Geo\TravelRoutesRepository;
use App\Repositories\Geo\VoyagesRepository;

class SeaFreightsController extends Controller
{
    public function index()
    {
        $travelRoutes = TravelRoutesRepository::getRoutes();
        $voyages = VoyagesRepository::getVoyagesWithPointLocation();

        $locations = LocationsRepository::getLocationsWithNexts();
        $locationsSelect = $locations->pluck('title', 'id')->toArray();

        $ships = Ship::where('owner_id', \Auth::id())->get();

        return $this->view('geo.business.sea_freights', [
            'ships' => $ships,
            'voyages' => $voyages,
            'routes' => $travelRoutes,
            'locationsSelect'  => $locationsSelect,
        ]);
    }
    
}
