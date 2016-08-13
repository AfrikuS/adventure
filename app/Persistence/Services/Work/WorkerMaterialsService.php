<?php

namespace App\Persistence\Services\Work;

use App\Persistence\Models\Hero;
use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\ShopRepo;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;

class WorkerMaterialsService
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

}
