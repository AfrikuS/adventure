<?php

namespace App\Factories;

use App\Models\Core\Thing;
use App\Models\Trade\AuctionLot;
use App\Models\Auth\User;
use App\Entities\Trade\ThingStateMachine;
use Carbon\Carbon;

class AuctionFactory
{
    public static function createLotByThing(ThingStateMachine $thing, User $owner, int $startBid)
    {
        $auctionStartStr = Carbon::create()->addMinutes(200)->toDateTimeString();

        return AuctionLot::create([
            'owner_id' => $owner->id,
            'owner_user_name' => $owner->name,
            'thing_id' => $thing->id,
            'thing_title' => $thing->title,
            'title' => $thing->title . ' + 1',
            'bid' => $startBid,
            'purchaser_id' => null,
            'date_time' => $auctionStartStr,
        ]);
    }
}
