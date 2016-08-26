<?php

namespace App\Modules\Work\Commands\Shop;

use App\Models\Work\Worker;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Work\Domain\Services\Shop\WorkerShopService;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;

class BuyInstrumentCommand
{
    /** @var ShopRepo */
    private $shopRepo;
    /** @var  WorkerRepo */
    private $workerRepo;
    /** @var  HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->shopRepo = app('WorkShopRepo');
        $this->workerRepo = app('WorkerRepo');
        $this->heroRepo = app('HeroRepo');
    }

    public function buyInstrument($code, $user_id)
    {

        $workerShopService = new WorkerShopService();
        
        
        
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
