<?php

namespace App\Modules\Drive\Controllers\Garage;

use App\Exceptions\DetailNotFoundExeption;
use App\Http\Controllers\Controller;
use App\Modules\Drive\Commands\Shop\BuyDetailCommand;
use App\Modules\Drive\Commands\Shop\UpdateDetailOffersCommand;
use App\Modules\Drive\Persistence\Repositories\ShopRepo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function index()
    {
        $driver_id = $this->user_id;

        /** @var ShopRepo $driveCatalogs */
        $driveCatalogs = app('DriveShopRepo');

        $detailsOffers = $driveCatalogs->getOffersWithKindsByDriver($driver_id);


        return $this->view('drive.garage.shop', [
            'detailsOffers' => $detailsOffers,
        ]);
    }

    public function buyDetail()
    {
        $data = Input::all();
        $offer_id = $data['offer_id'];

        $cmd = new BuyDetailCommand();
        
        try {
            
            $cmd->buyDetail($offer_id, $this->user_id);
            
        }
        catch (DetailNotFoundExeption $e) {
            
            Session::flash('message', 'Такой детали не существует!');
        }
            
        
        return Redirect::route('drive_garage_shop_page');
    }

    public function reindexPrices()
    {
        $cmd = new UpdateDetailOffersCommand();
        
        $cmd->updateOffers($this->user_id);
        
        
        return Redirect::route('drive_garage_shop_page');
    }

}
