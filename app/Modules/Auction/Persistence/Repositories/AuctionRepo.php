<?php

namespace App\Modules\Auction\Persistence\Repositories;


use App\Modules\Auction\Domain\Entities\Lot;
use App\Modules\Auction\Domain\Entities\Thing;
use App\Modules\Auction\Persistence\Dao\LotDao;
use App\Modules\Auction\Persistence\Dao\ThingsDao;
use App\Modules\Auction\Persistence\RedisDao\RedisLotsDao;
use App\Modules\Core\Facades\EntityStore;
use App\Serializers\RedisAuctionLot;

class AuctionRepo
{
    /** @var LotDao */
    private $lotsDao;

    /** @var RedisLotsDao */
    private $redisLotsDao;

    /** @var ThingsDao */
    private $thingsDao;

    public function __construct(LotDao $lotsDao, ThingsDao $things)
    {
        $this->lotsDao = $lotsDao;
        $this->thingsDao = $things;
    }

    public function findLotById($id)
    {
        $lot = EntityStore::get(Lot::class, $id);
        
        if (null !== $lot) {
            return $lot;
        }
        
        $lotData = $this->lotsDao->find($id);

        $lot = new Lot($lotData);



        $thing = $this->findThingSale($lot->thing_id);


        $lot->setThing($thing);


        EntityStore::add($lot, $lot->id);
        return $lot;
    }

    public function findThingSale($thing_id)
    {
        $thing = EntityStore::get(Thing::class, $thing_id);

        if (null !== $thing) {
            return $thing;
        }

        $thingData = $this->thingsDao->find($thing_id);

        $thing = new Thing($thingData);


        EntityStore::add($thing, $thing->id);
        return $thing;
    }
    

    public function getActiveLots()
    {
        $lotsData = $this->lotsDao->getActiveLots();
        
        return $lotsData;
    }

    public function getExpiredLots()
    {
        $lotsData = $this->lotsDao->getExpiredLots();

        return $lotsData;
    }

    public function getAllLots()
    {
        $lotsData = $this->lotsDao->get();

        return $lotsData;
    }

    public function deleteLotById($id)
    {
        $this->lotsDao->delete($id);

        $this->redisLotsDao->deleteLot($id);
    }

    public function getThingsForSale($hero_id)
    {
        $things = $this->thingsDao->getFreeThingsBy($hero_id);
        
        return $things;
    }

    public function getThingsBy($hero_id)
    {
        $things = $this->thingsDao->getBy($hero_id);

        return $things;
    }

    public function createLot($user_id, $userName, $thing_id, $thingTitle, $bid, $dateTime)
    {
        $lot_id = $this->lotsDao->create(
            $user_id, 
            $userName, 
            $thing_id, 
            $thingTitle, 
            $bid, 
            $dateTime
        );


        // redisDao
        $this->redisLotsDao->saveLotInRedis(
            $lot_id,
            $user_id,
            $userName,
            $thing_id,
            $thingTitle,
            $bid
        );
    }
    
}
