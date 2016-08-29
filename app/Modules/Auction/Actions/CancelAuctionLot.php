<?php

namespace App\Modules\Auction\Actions;

use App\Models\Trade\AuctionLot;
use App\Modules\Auction\Domain\Services\AuctionService;
use App\Modules\Auction\Persistence\Repositories\AuctionRepo;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;

class CancelAuctionLot
{
    /** @var  AuctionRepo */
    private $auctionRepo;
    /** @var  HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->auctionRepo = app('AuctionRepo');
        $this->heroRepo = app('HeroRepo');
    }

    public function cancelLot($lot_id)
    {
        /** @var AuctionLot $lot */
        $lot = $this->auctionRepo->findLotById($lot_id);

        $this->validate($lot);


        $auctionService = new AuctionService();

        \DB::beginTransaction();
        try {

            $auctionService->cancelLot($lot_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }

    private function validate($lot)
    {
    }
}
