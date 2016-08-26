<?php

namespace App\Modules\Work\Domain\Handlers\Order\Status;

use App\Modules\Work\Domain\Commands\Order\Status\OrderCompleted;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class OrderCompletedHandler
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }

    public function handle(OrderCompleted $command)
    {
        /** @var Order $order */
        $order = $this->orderRepo->find($command->order_id);


        $order->setStatusCompleted();


        $this->orderRepo->updateStatus($order);
    }
}
