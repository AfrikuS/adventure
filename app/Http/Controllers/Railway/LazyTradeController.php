<?php

namespace App\Http\Controllers\Railway;

use App\Commands\Railway\ReindexTradePricesCmd;
use App\Models\Railway\StationLicense;
use App\Models\Trade\LazyTrade;
use App\Models\Trade\TradePrice;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class LazyTradeController extends RailwayController
{
    public function index()
    {
        $license = $this->railwayRepo->findLicenseByHeroId($this->user_id);

        if (null === $license || $license->status != 'active') {

            Session::flash('message', 'You must buy license');
            return \Redirect::route('railway_director_page');
        }



        $prices = TradePrice::get();

        if ($prices->count() == 0) {

            TradePrice::create([
                'resource_code' => 'oil',
                'railway_price' => rand(3, 10),
                'sea_price' => rand(3, 10),
            ]);
            TradePrice::create([
                'resource_code' => 'water',
                'railway_price' => rand(3, 10),
                'sea_price' => rand(3, 10),
            ]);
        }

        $prices = TradePrice::get();
        $trades = LazyTrade::where('hero_id', $this->user_id)->get();


        return $this->view('railway.lazy_trades', [
            'prices' => $prices,
            'trades' => $trades,
            'license' => $license,
        ]);
    }
    
    public function add()
    {
        $data = Input::all();
        $code = $data['code'];

        $price = TradePrice::where('resource_code', $code)->first();
        $resource_price = $price->railway_price;
        $resourceAmount = 5;
        
        LazyTrade::create([
            'hero_id' => $this->user_id,
            'resource_code' => $code,
            'resource_amount' => $resourceAmount,
            'resource_price' => $resource_price, 
        ]);
        
        $hero = $this->heroRepo->findById($this->user_id);
//        $hero->increment($code, 230);
        $hero->decrement($code, $resourceAmount);

        return \Redirect::route('railway_trades_page');
    }

    public function take()
    {
        $data = Input::all();
        $trade_id = $data['trade_id'];

        $trade = LazyTrade::find($trade_id);
        $resource = $trade->resource_code;

        $price = TradePrice::where('resource_code', $resource)->first();
        
        $hero = $this->heroRepo->findById($this->user_id);

//        if ($resource == 'oil') {
        $goldAmount = $trade->resource_amount * $price->railway_price; 
        $hero->increment('gold', $goldAmount);

        $trade->delete();

        return \Redirect::route('railway_trades_page');
    }

    public function reindexPrices()
    {

        $cmd = new ReindexTradePricesCmd();

        $cmd->reindexPrices();


        return \Redirect::route('railway_trades_page');
    }
}
