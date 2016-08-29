<?php

namespace App\Modules\Geo\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Order;
use App\Modules\Geo\Persistence\Repositories\VoyagesRepo;
use Illuminate\Support\Facades\Input;

class TravelController extends Controller
{
    public function index()
    {
        /** @var VoyagesRepo $voyagesRepo */
        $voyagesRepo = app('VoyagesRepo');

        $voyages = $voyagesRepo->getVoyagesWithPointLocation();

        return $this->view('geo.travel', [
            'voyages' => $voyages,
        ]);
    }
    
/*    public function showOrder($id)
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
*/
}
