<?php

namespace App\Transactions\Trade;

use App\Models\Hero\Thing;
use App\Models\Trade\AuctionLot;
use App\Models\User;
use App\Serializers\RedisAuctionLot;
use App\Transactions\ResourcesTransactions;

class AuctionTransactions
{
    public static function commitPurchasing(AuctionLot $lot, $purchaser)
    {
        $thing = Thing::find($lot->thing_id, ['owner_id', 'status']);
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
