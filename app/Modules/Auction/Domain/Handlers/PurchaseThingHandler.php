<?php

namespace App\Modules\Auction\Domain\Handlers;

use App\Modules\Auction\Domain\Commands\PurchaseThing;
use App\Modules\Auction\Domain\Entities\Thing;
use App\Modules\Auction\Persistence\Repositories\ThingsRepo;

class PurchaseThingHandler
{
    /** @var ThingsRepo */
    private $thingsRepo;

    public function __construct(ThingsRepo $thingsRepo)
    {
        $this->thingsRepo = $thingsRepo;
    }

    public function handle(PurchaseThing $command)
    {
        /** @var Thing $thing */
        $thing = $this->thingsRepo->find($command->thing_id);

        $thing->unlock();
        $thing->changeOwner($command->purchaser_id);



        $this->thingsRepo->update($thing);
    }
}
