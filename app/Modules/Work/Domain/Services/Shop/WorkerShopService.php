<?php

namespace App\Modules\Work\Domain\Services\Shop;

use App\Modules\Hero\Domain\Commands\Resources\DecrementGold;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Work\Domain\Commands\Worker\AddInstrument;
use App\Modules\Work\Domain\Commands\Worker\AddMaterial;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;
use Illuminate\Support\Facades\Bus;

class WorkerShopService
{
    /** @var HeroRepo */
    private $heroRepo;

    /** @var ShopRepo */
    private $shopRepo;

    public function __construct()
    {
        $this->heroRepo = app('HeroRepo');
        $this->shopRepo = app('WorkShopRepo');
    }

    public function purchaseMaterial($worker_id, $code)
    {
        $shopMaterial = $this->shopRepo->findMaterialByCode($code);



        $decrementGold = new DecrementGold($worker_id, $shopMaterial->price);

        $addMaterial = new AddMaterial($worker_id, $code, $shopMaterial->amount);

        

        Bus::dispatch($decrementGold);

        Bus::dispatch($addMaterial);
    }
    
    
    public function purchaseInstrument($worker_id, $code)
    {
        $shopInstrument = $this->shopRepo->findInstrumentByCode($code);


        $decrementGold = new DecrementGold($worker_id, $shopInstrument->price);

        $addInstrument = new AddInstrument($worker_id, $code, $shopInstrument->charge);

        
        
        Bus::dispatch($decrementGold);

        Bus::dispatch($addInstrument);
    }
}
