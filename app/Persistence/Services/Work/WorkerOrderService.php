<?php

namespace App\Persistence\Services\Work;

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

}
