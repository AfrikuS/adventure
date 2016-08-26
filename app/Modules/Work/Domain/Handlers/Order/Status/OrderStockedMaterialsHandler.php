<?php

namespace App\Modules\Work\Domain\Handlers\Order\Status;

use App\Modules\Work\Domain\Commands\Order\Status\OrderStockedMaterials;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;

class OrderStockedMaterialsHandler
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }
    
    public function handle(OrderStockedMaterials $command)
    {
        $order = $this->orderRepo->find($command->order_id);

        $order->setStatusStockedMaterials();


        $this->orderRepo->updateStatus($order);
    }
}
