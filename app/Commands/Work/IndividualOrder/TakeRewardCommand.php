<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Core\Hero;
use App\Repositories\HeroRepository;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;

class TakeRewardCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;
    /** @var  WorkerRepositoryObj */
    private $workerRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(OrderRepositoryObj $orderRepo, WorkerRepositoryObj $workerRepo, HeroRepositoryObj $heroRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;
        $this->heroRepo = $heroRepo;
    }

    public function takeReward($order_id, $worker_id)
    {
        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($worker_id);

        $order =  $this->orderRepo->findSimpleOrderById($order_id);
        /** @var Hero $hero */
        $hero = $this->heroRepo->findById($worker_id);

        \DB::beginTransaction();
        try {

            $this->workerRepo->upSkillByCode($worker, $order->kind_work_title, 10);

            $this->heroRepo->incrementGold($hero, $order->price);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        $order->finishStockSkills();

        \DB::commit();
    }
}
