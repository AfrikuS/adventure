<?php

namespace App\Commands\Trade\Auction;

use App\Models\Trade\AuctionLot;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Trade\AuctionRepository;
use App\Serializers\RedisAuctionLot;
use App\Services\Transfers\HeroesGoldTransfer;
use App\Services\Transfers\TransferExecutor;
use Illuminate\Support\Facades\DB;

class CommitPurchasingCommand
{
    /** @var  AuctionRepository */
    private $auctionRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;
    /** @var TransferExecutor  */
    private $transferExecutor;

    public function __construct(AuctionRepository $auctionRepo, HeroRepositoryObj $heroRepo)
    {
        $this->auctionRepo = $auctionRepo;
        $this->heroRepo = $heroRepo;
        $this->transferExecutor = new TransferExecutor();
    }

    public function commitPurchasing(int $lot_id, int $purchaser_id)
    {
        /** @var AuctionLot $lot */
        $lot = $this->auctionRepo->findLotById($lot_id);

        $thing = $this->heroRepo->findThingById($lot->thing_id);
        
        $heroFrom = $this->heroRepo->findById($thing->owner_id);
        $heroTo = $this->heroRepo->findById($purchaser_id);
        
        \DB::beginTransaction();
        try {
            
            $transfer = new HeroesGoldTransfer($heroFrom, $heroTo, $lot->bid);
            
            $this->transferExecutor->executeTransfer($transfer);

            $thing->changeOwner($purchaser_id);

            $cmd = new RemoveLotFromAuction($this->auctionRepo, $this->heroRepo);
            
            $cmd->removeLotFromAuction($lot);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        DB::commit();
    }
}
