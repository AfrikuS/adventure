<?php

namespace App\Modules\Work\Domain\Handlers\Order;

use App\Modules\Work\Domain\Commands\Order\AcceptOrder;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class AcceptOrderHandler
{
    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct(OrdersRepo $ordersRepo)
    {
        $this->ordersRepo = $ordersRepo;
    }

    public function handle(AcceptOrder $command)
    {
        $order = $this->ordersRepo->find($command->order_id);


        $order->setAcceptor($command->worker_id);

        $order->setStatusAccepted();


        $this->ordersRepo->updateStatus($order);
    }
}
