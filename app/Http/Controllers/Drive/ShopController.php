<?php

namespace App\Http\Controllers\Drive;

use App\Commands\Drive\BuyDetailCommand;
use App\Commands\Drive\UpdateDetailOffersCommand;
use App\Exceptions\DetailNotFoundExeption;
use App\Models\Drive\Catalogs\DetailTitle;
use App\Models\Drive\Detail;
use App\Models\Drive\DetailOffer;
use App\Repositories\Drive\DetailRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ShopController extends AppController
{
    public function index()
    {
        $driver_id = $this->driver->id;
//        $kinds = DetailKind::get();
//
        $detailsOffers = DetailOffer::select('id', 'kind_id', 'title')
            ->where('driver_id', $driver_id)
            ->with('kind')
            ->get();

        return $this->view('drive.garage.shop', [
            'detailsOffers' => $detailsOffers,
        ]);
    }

    public function buyDetail()
    {
        $data = Input::all();
        $offer_id = $data['offer_id'];

        $cmd = new BuyDetailCommand(new DetailRepository());
        
        try {
            
            $cmd->buyDetail($offer_id, $this->driver->id);
            
        }
        catch (DetailNotFoundExeption $e) {
            
            Session::flash('message', 'Такой детали не существует!');
        }
            
        
        return Redirect::route('drive_garage_shop_page');
    }

    public function reindexPrices()
    {
        $driver_id = $this->driver->id;

        
        $cmd = new UpdateDetailOffersCommand(new DetailRepository());
        
        $cmd->updateOffers($driver_id);
        
        
        return Redirect::route('drive_garage_shop_page');
    }

}
