<?php

namespace App\Commands\Work\IndividualOrder;

use App\Persistence\Dao\HeroDao;
use App\Persistence\Dao\Work\OrderDao;
use App\Persistence\Models\Hero;
use App\Persistence\Models\Work\Order;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;

class TakeRewardCommand
{
//    /** @var OrderRepositoryObj */
    private $orderRepo;
    /** @var OrderDao */
    private $orderDao;

    /** @var  WorkerRepositoryObj */
    private $workerRepo;

    /** @var HeroDao */
    private $heroDao;

    public function __construct(OrderRepositoryObj $orderRepo, WorkerRepositoryObj $workerRepo, HeroRepositoryObj $heroRepo)
    {
//        $this->orderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;

        $this->heroDao = new HeroDao();
        $this->orderRepo = new OrderRepo();
        $this->orderDao = new OrderDao();
    }

    public function takeReward($order_id, $worker_id)
    {
        $worker = $this->workerRepo->findWithMaterialsAndSkillsById($worker_id);

//        $order =  $this->orderRepo->findSimpleOrderById($order_id);
        /** @var Order $order */
        $order = $this->orderRepo->find($order_id);
        
        /** @var Hero $hero */
        $hero = $this->heroDao->findById($worker_id);

        \DB::beginTransaction();
        try {

            $this->workerRepo->upSkillByCode($worker, $order->kind_work_title, 10);

            $hero->incrementGold($order->price);
            $this->heroDao->save($hero);

            $order->finishStockSkills();
            
            $this->orderDao->save($order);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }


        \DB::commit();
    }
}
