<?php

namespace App\Commands\Shop;

use App\Models\Core\Hero;
use App\Models\Work\Worker;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\ShopRepository;
use App\Repositories\Work\WorkerRepositoryObj;

class BuyInstrumentCommand
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

    public function buyInstrument($code, $user_id)
    {
        /** @var Worker $worker */
        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($user_id);
        /** @var Hero $hero */
        $hero = $this->heroRepo->findById($user_id);

        $instrumentPrice = ShopRepository::getInstrumentPriceByCode($code);

        \DB::beginTransaction();
        try {
            $this->heroRepo->decrementGold($hero, $instrumentPrice);
            
            $this->workerRepo->addInstrumentToWorker($worker, $code, 2);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }
}
