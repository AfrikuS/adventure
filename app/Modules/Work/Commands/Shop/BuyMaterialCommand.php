<?php

namespace App\Modules\Work\Commands\Shop;

use App\Models\Work\Worker;
use App\Modules\Hero\Persistence\Repositories\HeroRepo;
use App\Modules\Work\Domain\Services\Shop\WorkerShopService;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;

class BuyMaterialCommand
{
    /** @var ShopRepo */
    private $shopRepo;

    /** @var HeroRepo */
    private $heroRepo;

    public function __construct()
    {
        $this->shopRepo = app('WorkShopRepo');
        $this->heroRepo = app('HeroRepo');
    }

    // application Layer
    public function buyMaterial($code, $user_id)
    {

        // domain layer - work with data
        $service = new WorkerShopService();



        \DB::beginTransaction();
        try {

            
            $service->purchaseMaterial($user_id, $code);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
