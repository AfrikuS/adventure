<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Geo\Travel\MaterialPrice;
use App\Models\Geo\TravelShip;
use App\Repositories\Geo\TravelRepository;

class DockMarketController extends Controller
{
    public function index()
    {
        $travelShips = TravelRepository::getTravelShips();

        return $this->view('geo.market.dock_market', [
            'travelShips' => $travelShips,
        ]);
    }

    public function shipShop($id)
    {
        $ship = TravelShip::find($id);

        $materials = MaterialPrice::where('ship_id', $ship->id)->get();

        return $this->view('geo.market.ship_shop', [
//            'travelShips'=>$travelShips,
//            'ordersTimers' => $ordersTimers,
            'materials' => $materials,
        ]);
    }
}
