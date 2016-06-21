<?php

namespace App\Repositories;

use App\Models\AuctionLot;
use App\Models\HeroThing;
use App\Models\User;
use App\Serializers\RedisAuctionLot;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Mockery\CountValidator\Exception;
use Predis\Client;

class AuctionRepository
{
    public static function getActiveLots()
    {
        $lots = AuctionLot::
            select(['id', 'title', 'bid', 'owner_user_name', 'purchaser_user_name'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();

        return $lots;
    }

    public static function getThingsByUserId($userId)
    {
        $things = HeroThing::where('owner_id', $userId)->get(['id', 'title']);
        return $things;
    }

    public static function getExpiredLots()
    {
        $lots = AuctionLot::
            select(['id', 'title', 'date_time', 'owner_id', 'bid'])
            ->whereRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) < 0')
            ->get();

        return $lots;
    }

    public static function createLotFromThing(HeroThing $thing, $user, $startBid)
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
