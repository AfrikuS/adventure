<?php

namespace App\Transactions\Trade;

use App\Models\AuctionLot;
use App\Models\HeroThing;
use App\Models\User;
use App\Repositories\HeroResourcesRepository;
use App\Serializers\RedisAuctionLot;
use App\Transactions\ResourcesTransactions;

class AuctionTransactions
{
    public static function commitPurchasing(AuctionLot $lot, $purchaser)
    {
        $thing = HeroThing::find($lot->thing_id, ['owner_id', 'status']);
        $thingOwner = User::find($lot->owner_id, ['id', 'name']);
        
        \DB::transaction(function () use ($purchaser, $lot, $thing, $thingOwner) {
            ResourcesTransactions::transferGoldBetweenUsers($purchaser, $thingOwner, $lot->bid);
            
            $thing->update([
                'owner_id' => $purchaser->id,
                'status' => 'free',
            ]);

            RedisAuctionLot::deleteLot($lot->id); // todo review
            $lot->delete();
        });
    }
}
