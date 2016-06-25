<?php

namespace App\Repositories\Work;

use App\Factories\WorkFactory;
use App\Models\Work\Order;
use App\Models\Work\Worker;

class OrderRepository
{
    public static function isOrderReadyToWorks(Order $order)
    {
        return $order->status === 'stock_skills';
    }

    public static function findOnlyOrderById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ])
            ->find($id);

        return $order;
    }

    public static function hasWorkerNeedAmountMaterialForOrder(Worker $worker, Order $order, string $materialCode)
    {
        $orderMaterial = $order->getMaterialByCode($materialCode);
        $workerMaterial = $worker->getMaterialByCode($materialCode);
        
        if ($workerMaterial === null) {
            WorkFactory::createWorkerMaterial($worker, $materialCode);
            return false;
        }

        $needAmount = $orderMaterial->need - $orderMaterial->stock;
        return $needAmount <= $workerMaterial->value;
    }

    public static function findOrderWithMateriaslAndSkillsById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ])
            ->with('materials')
//            ->with('skills')
            ->find($id);

        return $order;
    }
}
