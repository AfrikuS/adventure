<?php

namespace App\Persistence\Services\Work\Order;

use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;

class OrderService
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function changeStatusAfterEstimating($order_id)
    {
        $order = $this->orderRepo->findSimpleOrder($order_id);
        
        $order->setStockMaterialsStatus();

        
        $this->orderRepo->updateStatus($order);
    }

    public function checkStatusAfterStockMaterial($order_id)
    {
        $stockDataDto = $this->orderRepo->getStockMaterialsData($order_id);


        $order = $this->orderRepo->findSimpleOrder($order_id);
//        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);


        if ($stockDataDto->isStockCompleted()) {

            $order->setStockSkillsStatus();

            $this->orderRepo->updateStatus($order);
        }

    }

    public function deleteWithMaterials($order_id)
    {
        $orderMaterialsRepo = new OrderMaterialsRepo();

        
        $orderMaterialsRepo->deleteByOrder($order_id);


        $this->orderRepo->deleteOrder($order_id);
    }
}
