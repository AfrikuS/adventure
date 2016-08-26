<?php

namespace App\Modules\Work\Domain\Handlers\Order;

use App\Modules\Work\Domain\Commands\Order\AcceptOrder;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class AcceptOrderHandler
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }

    public function handle(AcceptOrder $command)
    {
        $order = $this->orderRepo->find($command->order_id);


        $order->setAcceptor($command->worker_id);

        
        $this->orderRepo->updateStatus($order);
    }
}
