<?php

namespace App\Domain\Services\Work\Order;

use App\Persistence\Models\Work\Order;
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
        $order = $this->orderRepo->find($order_id);
        
        $order->setStatusStockMaterials();

        
        $this->orderRepo->updateStatus($order);
    }

    public function checkStatusAfterStockMaterial($order_id)
    {
        $stockDataDto = $this->orderRepo->getStockMaterialsData($order_id);


        $order = $this->orderRepo->find($order_id);
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

    public function changeStatusAfterApplyingSkill($order_id)
    {
        $order = $this->orderRepo->find($order_id);

        $order->setStatusCompleted();


        $this->orderRepo->updateStatus($order);
    }

    public function cancelStatusApplyingSkill($order_id)
    {
        $order = $this->orderRepo->find($order_id);

        $order->setStockSkillsStatus();

        $this->orderRepo->updateStatus($order);
    }

    private function changeStatusAfterAccepting(Order $order)
    {
        $order->setStatusAccepted();
    }

    public function accept($order_id, $worker_id)
    {
        $order = $this->orderRepo->find($order_id);


        $order->setAcceptor($worker_id);

        // as callback, event
        $this->changeStatusAfterAccepting($order);


        $this->orderRepo->updateStatus($order);
    }
}
