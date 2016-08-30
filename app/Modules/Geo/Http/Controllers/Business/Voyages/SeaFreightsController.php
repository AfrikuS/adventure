<?php

namespace App\Modules\Geo\Http\Controllers\Business\Voyages;

use App\Http\Controllers\Controller;
use App\Modules\Geo\Persistence\Repositories\Business\ShipsRepo;
use App\Modules\Geo\Persistence\Repositories\Business\VoyagesRepo;
use App\Modules\Geo\Persistence\Repositories\TravelRoutesRepo;

class SeaFreightsController extends Controller
{
    public function index()
    {
        /** @var TravelRoutesRepo $routesRepo */
        $routesRepo = app('TravelRoutesRepo');
        $committedRoutes = $routesRepo->getCommittedRoutes();


        $draftRoutes = $routesRepo->getDraftRoutes();
        
        /** @var VoyagesRepo $voyagesRepo */
        $voyagesRepo = app('VoyagesRepo');
        $voyages = $voyagesRepo->getStayingVoyages();

        $locationsRepo = app('LocationsRepo');
        $locations = $locationsRepo->getLocationsWithNexts();
        
        $locationsSelect = $locations->getViewSelect(); // presenter


        /** @var ShipsRepo $shipsRepo */
        $shipsRepo = app('ShipsRepo');

        $ships = $shipsRepo->getFreeByOwner($this->user_id);

        return $this->view('geo.business.voyages.sea_freights', [
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
