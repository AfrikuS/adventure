<?php

namespace App\Modules\Geo\Http\Controllers\Business;

use App\Factories\GeoFactory;
use App\Http\Controllers\Controller;
use App\Models\Geo\Trader\Ship;
use App\Models\Geo\TravelRoute;
use App\Models\Geo\Voyage;
use App\Repositories\Generate\EntityGenerator;
use App\Repositories\Geo\TravelRoutesRepository;
use App\Repositories\Geo\VoyagesRepository;
use Illuminate\Support\Facades\Input;

class ShipController extends Controller
{
    public function generateShip()
    {
        EntityGenerator::createShip();
        return redirect()->route('geo_sea_freights_page');
    }

    public function setShipOnRoute()
    {
        $data = Input::all();
        if ($data['route_id'] && $data['ship_id']) {

            $route_id = $data['route_id'];
            $ship_id = $data['ship_id'];

            $ship = Ship::find($ship_id)->update(['route_id' => $route_id]);
            /** @var TravelRoute $route */
            $route = TravelRoutesRepository::findById($route_id);
            
            GeoFactory::createVoyage($route, $ship);
        }

        return redirect()->route('geo_sea_freights_page');
    }
}
