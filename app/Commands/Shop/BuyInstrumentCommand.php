<?php

namespace App\Commands\Shop;

use App\Domain\Services\Work\WorkerShopService;
use App\Models\Core\Hero;
use App\Models\Work\Worker;
use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\ShopRepo;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;

class BuyInstrumentCommand
{
    /** @var ShopRepo */
    private $shopRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(WorkerRepositoryObj $workerRepo, ShopRepo $shopRepo, HeroRepo $heroRepo)
    {
        $this->shopRepo = $shopRepo;
        $this->workerRepo = $workerRepo;
        $this->heroRepo = $heroRepo;
    }

    public function buyInstrument($code, $user_id)
    {

        $workerShopService = new WorkerShopService($this->heroRepo, $this->shopRepo);
        
        
        
        \DB::beginTransaction();
        try {

            $workerShopService->purchaseInstrument($user_id, $code);
                
                
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
