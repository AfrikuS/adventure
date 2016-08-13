<?php

namespace App\Persistence\Services\Work;

use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\ShopRepo;
use App\Persistence\Repositories\Work\WorkerInstrumentsRepo;

class WorkerShopService
{
    /** @var HeroRepo */
    private $heroRepo;

    /** @var ShopRepo */
    private $shopRepo;

    public function __construct(HeroRepo $heroRepo, ShopRepo $shopRepo)
    {
        $this->heroRepo = $heroRepo;
        $this->shopRepo = $shopRepo;
    }

    public function purchaseInstrument($worker_id, $code)
    {
        // shopService ?
        $shopInstrumentDto = $this->shopRepo->findInstrumentByCode($code);



        

        $heroEvent = new DecrementGoldEvent($this->heroRepo);

        $heroEvent->handle($worker_id, $shopInstrumentDto->price);



        $event = new AddInstrumentEvent(new WorkerInstrumentsRepo());

        $event->handle($worker_id, $shopInstrumentDto->code, $shopInstrumentDto->charge);
    }
}
