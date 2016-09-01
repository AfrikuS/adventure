<?php

namespace App\Modules\Work\Commands\Order;

use App\Models\Work\Worker;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Domain\Services\Order\WorkerOrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Finite\Exception\StateException;

class StockMaterialAction
{
    /** @var OrdersRepo */
    private $ordersRepo;

    /** @var WorkerRepo */
    private $workerRepo;

    public function __construct()
    {
        $this->ordersRepo = app('OrdersRepo');
        $this->workerRepo = app('WorkerRepo');
    }

    public function addMaterial($order_id, $materialCode, $worker_id)
    {        
        $this->validateCommand($order_id);
        
        $workerOrderService = new OrderService();

        
        \DB::beginTransaction();
        try
        {
            
            
            $workerOrderService->stockMaterial($worker_id, $order_id, $materialCode);
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }
        \DB::commit();
    }

    private function validateCommand($order_id)
    {
        // validate code in order
        $order = $this->ordersRepo->find($order_id);

        if ($order->status != Order::STATUS_STOCK_MATERIALS) {

            throw new StateException;
        }
    }
}
