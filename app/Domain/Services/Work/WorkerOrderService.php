<?php

namespace App\Domain\Services\Work;

use App\Commands\Work\IndividualOrder\TakeRewardCommand;
use App\Domain\Events\Hero\IncrementGoldEvent;
use App\Domain\Events\Work\Order\StockMaterialEvent;
use App\Domain\Events\Work\Worker\DecrementMaterialEvent;
use App\Domain\Events\Work\Worker\IncrementSkillEvent;
use App\Persistence\Repositories\HeroRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;
use App\Persistence\Repositories\Work\WorkerRepo;

class WorkerOrderService
{
    /** @var OrderRepo */
    private $orderRepo;

    /** @var WorkerRepo */
    private $workerRepo;
    
    /** @var WorkerMaterialsRepo */
    private $workerMaterialsRepo;
    
    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;
    
    public function __construct(OrderRepo $orderRepo,
                                WorkerRepo $workerRepo
    )
    {
        $this->orderRepo = $orderRepo;
        $this->workerRepo = $workerRepo;
        
        $this->workerMaterialsRepo = new WorkerMaterialsRepo();
        $this->orderMaterialsRepo = new OrderMaterialsRepo();
    }

    public function stockMaterial($worker_id, $order_id, $code)
    {
        $orderMaterial = $this->orderRepo->findMaterialBy($order_id, $code);
        
        $needMaterialAmount = $orderMaterial->need - $orderMaterial->stock;  
        
        
        
        $workerEvent = new DecrementMaterialEvent($this->workerMaterialsRepo);

        $workerEvent->handle($worker_id, $code, $needMaterialAmount);
        
        
        
        $orderEvent = new StockMaterialEvent($this->orderMaterialsRepo);
        
        $orderEvent->handleMaterial($orderMaterial, $needMaterialAmount);
    }

    public function takeReward($order_id, $worker_id)
    {
//        $takeRewardCmd = new TakeRewardCommand($this->orderRepo, $this->workerRepo, new HeroRepositoryObj());

//        $takeRewardCmd->takeReward($order_id, $worker_id);
        $heroRepo = new HeroRepo();
        
        $order = $this->orderRepo->find($order_id);
        

        $heroEvent = new IncrementGoldEvent($heroRepo);

        $heroEvent->handle($worker_id, $order->price);



//        $this->workerRepo->upSkillByCode($worker, $order->kind_work_title, 10);


//        $order->finishStockSkills();

//        $this->orderDao->save($order);

    }

    public function workProcess($order_id, $worker_id)
    {
        $order = $this->orderRepo->find($order_id);

        // calculate skillAmount
        
        $code = $skillSphere = $order->kind_work_title; // $order->skill_sphere = 


        $upSkill = new IncrementSkillEvent();

        $upSkill->handle($worker_id, $code, 5);

//        $isUpperSkill = true;

    }

}
