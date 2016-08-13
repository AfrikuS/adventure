<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Worker;
use App\Persistence\Models\Work\Order;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerRepo;
use App\Persistence\Services\Work\WorkerOrderService;
use App\Persistence\Services\Work\Order\OrderService;

class AddMaterialCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    /** @var  WorkerRepo */
    private $workerRepo;

    public function __construct(OrderRepo $orderRepo,  WorkerRepo $workerRepo)
    {
        $this->orderRepo = new OrderRepo();
        $this->workerRepo = new WorkerRepo();
    }

    public function addMaterial($order_id, $materialCode, $worker_id)
    {        
        $workerOrderService = new WorkerOrderService($this->orderRepo, $this->workerRepo);

        $orderService = new OrderService($this->orderRepo);
        
        \DB::beginTransaction();
        try
        {
            $workerOrderService->stockMaterial($worker_id, $order_id, $materialCode);


            // as event-callback
            $orderService->checkStatusAfterStockMaterial($order_id);

            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }
        \DB::commit();
        
    }
}
