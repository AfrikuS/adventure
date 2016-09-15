<?php

namespace App\Modules\Auction\Domain\Services;

use App\Modules\Auction\Domain\Commands\PurchaseThing;
use App\Modules\Auction\Domain\Entities\Lot;
use App\Modules\Auction\Domain\Entities\Thing;
use App\Modules\Auction\Persistence\Repositories\AuctionRepo;
use App\Modules\Auction\Persistence\Repositories\ThingsRepo;
use App\Modules\Core\Entities\AppUser;
use App\Modules\Hero\Domain\Services\ResourceTransferService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;

class AuctionService
{
    /** @var AuctionRepo */
    private $lots;

    /** @var ThingsRepo */
    private $things;

    /** @var ResourceTransferService */
    private $resourceTransfer;

    public function __construct()
    {
        $this->lots = app('AuctionRepo');
        $this->things = app('ThingsRepo');

        $this->resourceTransfer = new ResourceTransferService();
    }

    public function createLot(Thing $thing, AppUser $user, $bid)
    {
        $auctionStartStr = Carbon::create()->addMinutes(200)->toDateTimeString();

        $this->lots->createLot(
            $user->id,
            $user->name,
            $thing->id,
            $thing->title,
            $bid,
            $auctionStartStr
        );

        $thing->lock();

        $this->things->update($thing);
    }

    public function cancelLot($lot_id)
    {
        /** @var Lot $lot */
        $lot = $this->lots->findLotById($lot_id);

        $saleThing = $lot->thing;
        
        $saleThing->unlock();
        $this->things->update($saleThing);
        
        
        $this->lots->deleteLotById($lot_id);
    }

    /** @deprecated  */
    public function commitThingTrade($lot_id, $purchaser_id)
    {
        $purchaser = 'ThingTrader'; // user with resource_amount
        $oldOwner = 'ThingTrader'; // user with resource_amount


    }

    public function performDeal($lot_id, $purchaser_id)
    {
        /** @var Lot $lot */
        $lot = $this->lots->findLotById($lot_id);


        $purchaseThing = new PurchaseThing($lot->thing->id, $purchaser_id);
        Bus::dispatch($purchaseThing);


        $this->resourceTransfer->transferGold($purchaser_id, $lot->thing->owner_id, $lot->bid);


        $this->lots->deleteLotById($lot_id);
    }
}

