<?php

namespace App\Factories;

use App\Models\AuctionLot;
use App\Models\HeroThing;
use Carbon\Carbon;

class AuctionFactory
{
    public static function createLotByThing(HeroThing $thing, $user, int $startBid)
    {
        $auctionStartStr = Carbon::create()->addMinutes(200)->toDateTimeString();

        $lot = new AuctionLot();
        $lot->owner_id = $user->id;
        $lot->owner_user_name = $user->name;
        $lot->thing_id = $thing->id;
        $lot->thing_title = $thing->title;
        $lot->title  = $thing->title . ' + 1';
        $lot->bid  = $startBid;
        $lot->purchaser_id  = null;
        $lot->date_time = $auctionStartStr;
        $lot->save();

        return $lot;
    }
}
