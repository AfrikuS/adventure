<?php

namespace App\Http\Controllers\Trade;

use App\Domain\AuctionActions;
use App\Factories\AuctionFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\AuctionAddLotRequest;
use App\Http\Requests\AuctionBuyLotRequest;
use App\Models\AuctionLot;
use App\Models\HeroThing;
use App\Repositories\AuctionRepository;
use App\Repositories\HeroRepository;
use App\Repositories\HeroResourcesRepository;
use App\Serializers\RedisAuctionLot;
use App\Transactions\Trade\AuctionTransactions;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuctionController extends Controller
{
    public function index()
    {
        $lots = AuctionRepository::getActiveLots();
        $heroThings = HeroRepository::getHeroThings(\Auth::user());

        $thingsForSale = $heroThings->filter(function ($thing) {
            return $thing->status === 'free';
        });

        $expiredLots = AuctionRepository::getExpiredLots();
        
        $userJson = json_encode(['id' => $this->user_id, 'name' => auth()->user()->name]);

        return $this->view('trade.auction.auction', [
            'lots' => $lots,
            'heroThings' => $heroThings,
            'thingsForSale' => $thingsForSale,
            'expiredLots' => $expiredLots,
            'userJson' => $userJson,
        ]);
    }

    public function addLot(AuctionAddLotRequest $request)
    {
        $thing = HeroRepository::findHeroThingById($request->thing_id);

        $lot = AuctionFactory::createLotByThing($thing, auth()->user(), $request->bid);
        $thing->lock();

        RedisAuctionLot::saveLotInRedis($lot);

        Session::flash('message', 'Lot is added successfully!');

        return redirect()->route('auction_page');
    }


    public function buy(AuctionBuyLotRequest $request)
    {
        $lot_id = $request->get('lot_id');
        $lot = AuctionLot::find($lot_id, ['id', 'owner_id', 'thing_id','bid']);
        $purchaser = auth()->user();

        if ($lot != null) {
            AuctionTransactions::commitPurchasing($lot, $purchaser);
        }
        else {
            Session::flash('message', 'Lot is bought yet!');
        }
        
        return redirect()->route('auction_page');
    }
}
