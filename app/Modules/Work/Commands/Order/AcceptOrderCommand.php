<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Finite\Exception\StateException;

class AcceptOrderCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    /** @var  WorkerRepo */
    private $workerRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
        $this->workerRepo = app('WorkerRepo');
    }

    public function acceptOrder($order_id, $worker_id)
    {
        $this->validateCommand($order_id);

        /** @var OrderService $orderService */
        $orderService = app('OrderService');



        \DB::beginTransaction();
        try {


            $orderService->accept($order_id, $worker_id);



        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateCommand($order_id)
    {
        $order = $this->orderRepo->find($order_id);

        if ($order->status != Order::STATUS_FREE) {

            throw new StateException;
        }
    }
}
