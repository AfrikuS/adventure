<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\SeaCreateOrderRequest;
use App\Models\Geo\Travel\MaterialPrice;
use App\Models\Work\Order;
use App\Repositories\Geo\SeaRepository;
use App\Repositories\Geo\VoyagesRepository;
use App\Repositories\Geo\TravelRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TravelController extends Controller
{
    public function index()
    {

        $voyages = VoyagesRepository::getVoyagesWithPointLocation();

        return $this->view('geo.travel', [
            'voyages' => $voyages,
        ]);
    }
    
    public function showOrder($id)
    {
        $travel = Order::find($id, ['id', 'destination', 'resource_code']);

//        if (null == $travel) {
//            Session::flash('message', 'Travel is ended yet!');
//            return redirect()->route('geo_travels_page');
//        }
        
        return $this->view('geo.travel_order', [
            'travel'=>$travel,
        ]);
    }
    
    public function createOrder()
    {
        $data = Input::all();
//        $travel_id = $request->get('travel_id');
//        $timeMinutes = $request->get('time');

//        $travel = TravelShip::find($travel_id, ['destination', 'resource_code']);
//
//        if (null == $travel) {
//            Session::flash('message', 'Travel is ended yet!');
//            return redirect()->route('geo_travels_page');
//        }
//
//        SeaRepository::createOrderOnTravel(\Auth::user(), $travel, $timeMinutes);
//        Session::flash('message', 'Travel Order is created!');

        return redirect()->route('geo_travels_page');
    }

}
