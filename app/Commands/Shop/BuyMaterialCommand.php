<?php

namespace App\Commands\Shop;

use App\Models\Work\Worker;
use App\Persistence\Models\Work\Shop;
use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\ShopRepo;
use App\Persistence\Services\Work\WorkerMaterialsService;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\ShopRepository;

class BuyMaterialCommand
{
    /** @var ShopRepository */
    private $shopRepo;

    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(HeroRepo $heroRepo, ShopRepo $shopRepo)
    {
        $this->shopRepo = $shopRepo;
        $this->heroRepo = $heroRepo;
    }

    // application Layer
    public function buyMaterial($code, $user_id)
    {

        // domain layer - work with data
        $service = new WorkerMaterialsService(
            $this->heroRepo,
            $this->shopRepo
        );



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
