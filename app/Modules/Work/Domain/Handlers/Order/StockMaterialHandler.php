<?php

namespace App\Modules\Work\Domain\Handlers\Order;

use App\Modules\Work\Domain\Commands\Order\StockMaterial;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class StockMaterialHandler
{
    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct(OrdersRepo $ordersRepo)
    {
        $this->ordersRepo = $ordersRepo;
    }

    public function handle(StockMaterial $command)
    {
        /** @var Order $order */
        $order = $this->ordersRepo->findOrderWithMaterialsById($command->order_id);
        
        $material = $order->materials->getBy($command->materialCode);

        
        $material->stockAmount($command->amount);
        

        
        $this->ordersRepo->updateMaterialAmount($material);
        
        
        
        $this->checkStatusAfterStockMaterial($order);
    }

    private function checkStatusAfterStockMaterial(Order $order)
    {
        if ($order->materials->isStockCompleted()) {


            $order->setStatusStockedMaterials();


            $this->ordersRepo->updateStatus($order);
        }
    }
}
