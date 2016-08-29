<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Factories\WorkerFactory;
use App\Http\Controllers\Controller;
use App\Models\Geo\Trader;
use App\Repositories\Geo\LocationsRepository;
use App\Repositories\Geo\TravelRoutesRepository;
use App\Repositories\Geo\VoyagesRepository;

class TraderController extends Controller
{
    public function profile()
    {
        $user_id = \Auth::id();
        if (null === Trader::find(\Auth::id())) {
            Trader::create([
                'id' => $user_id,
            ]);
        }


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
}
