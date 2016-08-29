<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Geo\Trader;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\Persistence\Repositories\VoyagesRepo;
use App\Repositories\Geo\TravelRoutesRepository;

class BusinessController extends Controller
{
    public function profile()
    {
        $user_id = \Auth::id();
        if (null === Trader::find(\Auth::id())) {
            Trader::create([
                'id' => $user_id,
            ]);
        }


        /** @var VoyagesRepo $voyagesRepo */
        $voyagesRepo = app('VoyagesRepo');

        /** @var LocationsRepo $locationsRepo */
        $locationsRepo = app('LocationsRepo');
        
//        $travelRoutes = TravelRoutesRepository::getRoutes();
//        $voyages = $voyagesRepo->getVoyagesWithPointLocation();
//
//        $locations = $locationsRepo->getLocationsWithNexts();
//
//        $locationsSelect = $locations->getViewSelect(); //$locations->pluck('title', 'id')->toArray();


        return $this->view('geo.business.business_index', [
//            'voyages' => $voyages,
//            'routes' => $travelRoutes,
//            'locationsSelect'  => $locationsSelect,
        ]);
    }
}
