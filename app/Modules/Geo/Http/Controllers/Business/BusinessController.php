<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Modules\Core\Http\Controller;
use App\Models\Geo\Trader;
use App\Modules\Geo\Persistence\Repositories\LocationsRepo;
use App\Modules\Geo\Persistence\Repositories\VoyagesRepo;
use App\Repositories\Geo\TravelRoutesRepository;

class BusinessController extends Controller
{
    public function profile()
    {
        if (null === Trader::find($this->user_id)) {
            Trader::create([
                'id' => $this->user_id,
            ]);
        }


//        /** @var VoyagesRepo $voyagesRepo */
//        $voyagesRepo = app('VoyagesRepo');
//
//        /** @var LocationsRepo $locationsRepo */
//        $locationsRepo = app('LocationsRepo');
//        


        return $this->view('geo.business.business_index', [
        ]);
    }
}
