<?php

namespace App\Http\Controllers\Geo;

use App\Domain\SeaActions;
use App\Http\Requests\SeaCreateOrderRequest;
use App\Models\AuctionLot;
use App\Models\HeroResources;
use App\Models\Sea\TravelOrder;
use App\Models\Sea\TravelShip;
use App\Models\User;
use App\Models\Work\Order;
use App\Repositories\Geo\VoyagesRepository;
use App\Repositories\SeaRepository;
use App\Repositories\TravelRepository;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TravelController extends Controller
{
    public function index()
    {
        $travelShips = TravelRepository::getTravelShips();
        $ordersTimers = TravelRepository::getActiveOrdersTimersByUser($this->user_id);
        
        $voyages = VoyagesRepository::getVoyagesWithPointLocation();

        return $this->view('geo/travel', [
            'travelShips'=>$travelShips,
            'ordersTimers' => $ordersTimers,
            'voyages' => $voyages,
        ]);
    }
    
    public function showOrder($id)
    {
        $travel = Order::find($id, ['id', 'destination', 'resource_code']);

        if (null == $travel) {
            Session::flash('message', 'Travel is ended yet!');
            return redirect('/geo/travel');
        }
        
        return $this->view('geo/travel_order', [
            'travel'=>$travel,
        ]);
    }
    
    public function createOrder(SeaCreateOrderRequest $request)
    {
        $travel_id = $request->get('travel_id');
        $timeMinutes = $request->get('time');

        $travel = TravelShip::find($travel_id, ['destination', 'resource_code']);

        if (null == $travel) {
            Session::flash('message', 'Travel is ended yet!');
            return redirect('/geo/travel');
        }

        SeaRepository::createOrderOnTravel($travel, $timeMinutes);
        Session::flash('message', 'Travel Order is created!');

        return redirect()->route('sea_travels_page');
    }
}
