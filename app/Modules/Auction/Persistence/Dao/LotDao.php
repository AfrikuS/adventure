<?php

namespace App\Modules\Auction\Persistence\Dao;

use App\Exceptions\Persistence\EntityNotFound_Exception;

class LotDao
{
    private $table = 'auction_lot';

    public function find($id)
    {
        $lotData =
            \DB::table($this->table)
                ->select(['id', 'owner_id', 'thing_id', 'bid'])
                ->find($id);

        if (null === $lotData) {
            throw new EntityNotFound_Exception;
        }
        
        return $lotData;
    }

    public function getActiveLots()
    {
        $lotsData =
            \DB::table($this->table)
                ->select(['id', 'title', 'bid', 'owner_user_name', 'purchaser_user_name'])
                ->selectRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) AS duration_seconds')
                ->havingRaw('duration_seconds > 0')
                ->get();
        
        return $lotsData;
    }

    public function getExpiredLots()
    {
        $lotsData =
            \DB::table($this->table)
                ->select(['id', 'title', 'date_time', 'owner_id', 'bid', 'thing_id'])
                ->whereRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) < 0')
                ->get();

        return $lotsData;
    }

    public function get()
    {
        $lotsData =
            \DB::table($this->table)
                ->select(['id', 'title', 'bid', 'owner_user_name', 'owner_id', 'purchaser_user_name'])
                ->selectRaw('TIMESTAMPDIFF(SECOND, now(), auction_lot.date_time) AS duration_seconds')
                ->get();

        return $lotsData;
    }

    public function delete($id)
    {
        \DB::table($this->table)->delete($id);
    }

    public function create($owner_id, $ownerName, $thing_id, $thingTitle, $bid, $dateTime)
    {
        return 
            \DB::table($this->table)->insertGetId([
                'owner_id' => $owner_id,
                'owner_user_name' => $ownerName,
                'thing_id' => $thing_id,
                'thing_title' => $thingTitle,
                'title' => $thingTitle . ' + 1',
                'bid' => $bid,
                'purchaser_id' => null,
                'date_time' => $dateTime,
            ]);
    }
}
