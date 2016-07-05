<?php

namespace App\Commands\Trade\Auction;

use App\Models\Trade\AuctionLot;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Trade\AuctionRepository;
use App\Serializers\RedisAuctionLot;

class RemoveLotFromAuction
{
    /** @var  AuctionRepository */
    private $auctionRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(AuctionRepository $auctionRepo, HeroRepositoryObj $heroRepo)
    {
        $this->auctionRepo = $auctionRepo;
        $this->heroRepo = $heroRepo;
    }

    public function removeLotFromAuction(AuctionLot $lot)
    {
//        /** @var AuctionLot $lot */
//        $lot = $this->auctionRepo->findLotById($lot_id);

        $thing = $this->heroRepo->findThingById($lot->thing_id);

        \DB::beginTransaction();
        try {

            $thing->unlock();

            $this->auctionRepo->deleteLotById($lot->id);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        RedisAuctionLot::deleteLot($lot->id);

        \DB::commit();
    }
}
