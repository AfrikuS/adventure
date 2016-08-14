<?php

namespace App\Domain\Services\Work;

use App\Domain\Events\Work\Worker\AddInstrumentEvent;
use App\Domain\Events\Work\Worker\AddMaterialEvent;
use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\ShopRepo;
use App\Persistence\Repositories\Work\WorkerInstrumentsRepo;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;
use App\Domain\Events\Hero\DecrementGoldEvent;

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

    public function purchaseMaterial($worker_id, $code)
    {
        $shopMaterialDto = $this->shopRepo->findMaterialByCode($code);


        $heroEvent = new DecrementGoldEvent($this->heroRepo);

        $heroEvent->handle($worker_id, $shopMaterialDto->price);



        $event = new AddMaterialEvent(new WorkerMaterialsRepo());

        $event->handle($worker_id, $shopMaterialDto->code, $shopMaterialDto->amount);
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
