<?php

namespace App\Modules\Auction\Actions;

use App\Models\Trade\AuctionLot;
use App\Modules\Auction\Domain\Entities\Lot;
use App\Modules\Auction\Domain\Services\AuctionService;
use App\Modules\Auction\Persistence\Repositories\AuctionRepo;
use App\Repositories\HeroRepositoryObj;
use App\Services\Transfers\HeroesGoldTransfer;
use App\Services\Transfers\TransferExecutor;
use Illuminate\Support\Facades\DB;

class CommitPurchasingCommand
{
    /** @var  AuctionRepo */
    private $auctionRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;
    /** @var TransferExecutor  */
    private $transferExecutor;

    public function __construct()
    {
        $this->auctionRepo = app('AuctionRepo');
        $this->heroRepo = app('HeroRepo');
        $this->transferExecutor = new TransferExecutor();
    }

    public function commitPurchasing(int $lot_id, int $purchaser_id)
    {
        /** @var AuctionLot $lot */
        $lot = $this->auctionRepo->findLotById($lot_id);

        $this->validateAction($lot);

//        $thing = $this->heroRepo->findThingById($lot->thing_id);
        
//        $heroFrom = $this->heroRepo->findById($thing->owner_id);
//        $heroTo = $this->heroRepo->findById($purchaser_id);

        $auctionService = new AuctionService();

        \DB::beginTransaction();
        try {
            
//            $transfer = new HeroesGoldTransfer($heroFrom, $heroTo, $lot->bid);
//            
//            $this->transferExecutor->executeTransfer($transfer);

            $auctionService->performDeal($lot_id, $purchaser_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        DB::commit();
    }

    private function validateAction(Lot $lot)
    {
    }
}
