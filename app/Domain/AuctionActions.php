<?php

namespace App\Domain;

use App\Models\AuctionLot;
use App\Models\HeroResources;
use App\Models\HeroThing;
use App\Repositories\AuctionRepository;
use App\Serializers\RedisAuctionLot;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AuctionActions
{
    /**
     * @deprecated
     */
    public static function createLot($data)
    {
    }

    public static function commitPurchase(AuctionLot $lot)
    {
        $purchaserResources = HeroResources::find($lot->purchaser_id);
        $ownerResources = HeroResources::find($lot->owner_id);
        $thing = HeroThing::find($lot->thing_id);

        $ownerResources->gold += $lot->bid;
        $purchaserResources->gold -= $lot->bid;
        $thing->owner_id = $lot->purchaser_id;
//        $thing->status = 'free';

        $ownerResources->save();
        $purchaserResources->save();
        $thing->save();
        $lot->delete();
    }

    public static function rollbackLot(AuctionLot $lot)
    {
//        $thing = HeroThing::find($lot->thing_id);
//        $thing->status = 'free';
        
        $lot->delete();
    }

    /**
     * @deprecated 
     */
    public static function buyLot($data)
    {
    }
}
