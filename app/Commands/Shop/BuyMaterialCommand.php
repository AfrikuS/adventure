<?php

namespace App\Commands\Shop;

use App\Models\Core\Hero;
use App\Models\Work\Worker;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\ShopRepository;
use App\Repositories\Work\WorkerRepositoryObj;

class BuyMaterialCommand
{
    /** @var ShopRepository */
    private $shopRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(WorkerRepositoryObj $workerRepo, ShopRepository $shopRepo, HeroRepositoryObj $heroRepo)
    {
        $this->shopRepo = $shopRepo;
        $this->workerRepo = $workerRepo;
        $this->heroRepo = $heroRepo;
    }

    public function buyMaterial($materialCode, $user_id)
    {
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($user_id);

        /** @var Hero $hero */
        $hero = $this->heroRepo->findById($user_id);

        $materialPrice = ShopRepository::getMaterialPriceByCode($materialCode);

        \DB::beginTransaction();

        try {
            $this->heroRepo->decrementGold($hero, $materialPrice);
            
            $this->workerRepo->addMaterialToWorker($worker, $materialCode, 60);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
