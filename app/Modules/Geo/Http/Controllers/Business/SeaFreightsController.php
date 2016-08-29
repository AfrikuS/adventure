<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Modules\Geo\Persistence\Repositories\Business\ShipsRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;

class SeaFreightsController extends Controller
{
    public function index()
    {
        /** @var TravelRoutesRepo $routesRepo */
        $routesRepo = app('TravelRoutesRepo');
        $committedRoutes = $routesRepo->getCommittedRoutes();


//        get $draftRoutes from routesCollection 
        $draftRoutes = $routesRepo->getDraftRoutes();
        
//        $travelRoutes = TravelRoutesRepository::getRoutes();

        $voyagesRepo = app('VoyagesRepo');
        $voyages = $voyagesRepo->getVoyagesWithPointLocation();

        $locationsRepo = app('LocationsRepo');
        $locations = $locationsRepo->getLocationsWithNexts();
        
        $locationsSelect = $locations->getViewSelect(); // presenter


        /** @var ShipsRepo $shipsRepo */
        $shipsRepo = app('ShipsRepo');

//        $ships = Ship::where('owner_id', \Auth::id())->get();
        $ships = $shipsRepo->getFreeByOwner($this->user_id);

        return $this->view('geo.business.sea_freights', [
            'ships' => $ships,
            'voyages' => $voyages,
            'routes' => $committedRoutes,
            'draftRoutes' => $draftRoutes,
            'locationsSelect'  => $locationsSelect,
        ]);
    }


    public function generateShip()
    {
        /** @var ShipsRepo $shipsRepo */
        $shipsRepo = app('ShipsRepo');

        $shipsRepo->create($this->user_id);


        return \Redirect::route('geo_sea_freights_page');
    }

}
