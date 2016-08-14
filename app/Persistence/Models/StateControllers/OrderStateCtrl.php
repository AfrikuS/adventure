<?php

namespace App\Persistence\Models\StateControllers;

use App\Persistence\Models\Work\Order;
use Finite\Exception\StateException;

class OrderStateCtrl
{
    public static function validateApplySkill($order)
    {
        if ($order->status != 'stock_skills') {

            throw new StateException;
        }
    }

    public function canAccepted(Order $order)
    {
        return $order->status === 'free';
    }

    public function canEstimated(Order $order)
    {
        return $order->status === 'accepted';
    }

    public function canStockMaterials(Order $order)
    {
        return $order->status === 'stock_materials';
    }

    public function canApplySkill(Order $order)
    {
        return $order->status === 'stock_skills';
    }
}
