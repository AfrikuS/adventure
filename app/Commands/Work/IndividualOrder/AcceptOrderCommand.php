<?php

namespace App\Commands\Work\IndividualOrder;

use App\Domain\Services\Work\Order\OrderService;
use App\Persistence\Models\Work\Order;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerRepo;

class AcceptOrderCommand
{
//    /** @var OrderRepositoryObj */
//    private $orderRepo;

    /** @var OrderRepo */
    private $orderRepo;

    /** @var  WorkerRepo */
    private $workerRepo;

    public function __construct()
    {
//        $this->orderRepo = $orderRepo;

        $this->orderRepo = new OrderRepo();
        $this->workerRepo = new WorkerRepo();

    }

    public function acceptOrder($order_id, $worker_id)
    {
//        $worker = $this->workerRepo->findSimpleWorker($worker_id);
//
//        /** @var Order $order */
//        $order = $this->orderRepo->findSimpleOrder($order_id);
//        
//        $order->setAcceptor($worker);
//
//        // as callback
//        $order->changeStatusAfterAccepting();
//
//        $this->orderRepo->updateAcceptor($order);
//


        $orderService = new OrderService($this->orderRepo);

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
}
