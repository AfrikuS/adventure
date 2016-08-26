<?php

namespace App\Modules\Work\Domain\Handlers\Order\Status;

use App\Modules\Work\Domain\Commands\Order\Status\OrderAccepted;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class OrderAcceptedHandler
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }
    
    public function handle(OrderAccepted $command)
    {
        /** @var Order $order */
        $order = $this->orderRepo->find($command->order_id);


        $order->setStatusAccepted();
        
        
        $this->orderRepo->updateStatus($order);
    }
}
