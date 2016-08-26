<?php

namespace App\Persistence\Models\StateControllers;

use App\Persistence\Models\Work\Order;
use App\Persistence\Repositories\Work\OrderRepo;
use Finite\Exception\StateException;

class OrderStateCtrl
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }

    public function validateApplySkill($order_id)
    {
    }

    public function canEstimated(Order $order)
    {
        return $order->status === 'accepted';
    }

    public function canStockMaterials(Order $order)
    {
        return $order->status === 'stock_materials';
    }

//    public function canApplySkill(Order $order)
//    {
//        return $order->status === 'stock_skills';
//    }
}
