<?php

namespace App\Http\Controllers\Trade;

use App\Domain\AuctionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\AuctionAddLotRequest;
use App\Http\Requests\AuctionBuyLotRequest;
use App\Models\AuctionLot;
use App\Models\HeroThing;
use App\Repositories\AuctionRepository;
use App\Repositories\HeroResourcesRepository;
use App\Serializers\RedisAuctionLot;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuctionController extends Controller
{
    public function index()
    {
        $lots = AuctionRepository::getActiveLots();
        $heroThings = HeroThing::where('owner_id', $this->user_id)->get(['id', 'title', 'status']);

        $thingsForSale = $heroThings->filter(function ($thing) {
            return $thing->status === 'free';
        });

        $expiredLots = AuctionRepository::getExpiredLots();
        
        $userJson = json_encode(['id' => $this->user_id, 'name' => auth()->user()->name]);

        return $this->view('auction/auction', [
            'lots' => $lots,
            'heroThings' => $heroThings,
            'thingsForSale' => $thingsForSale,
            'expiredLots' => $expiredLots,
            'userJson' => $userJson,
        ]);
    }

    public function addLot(AuctionAddLotRequest $request)
    {
        $data = $request->all();
        $thing = HeroThing::select(['id', 'title', 'status'])->find($data['thing_id']);

        $lot =  AuctionRepository::createLotFromThing($thing, auth()->user(), $data['bid']);
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

        try {
            DB::transaction(function () use ($purchaser, $lot) {
                HeroResourcesRepository::transferGoldBetweenUsers($purchaser->id, $lot->owner_id, $lot->bid);

                HeroThing::
                    where('id', '=', $lot->thing_id)
                    ->update([
                        'owner_id' => $purchaser->id,
                        'status' => 'free',
                    ]);

                RedisAuctionLot::deleteLot($lot->id);
                $lot->delete();
            });
        }
        catch (\Exception $e) {
            Session::flash('message', 'Lot is bought yet!');
        }

        return redirect()->route('auction_page');
    }
}
