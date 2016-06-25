<?php

namespace App\Deleters;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;

class WorkDeleter
{
    public static function deleteOrderWithMaterials(Order $order)
    {
        \DB::transaction(function () use ($order) {
            OrderMaterials::where('order_id', $order->id)->delete();
//            Order::where('order_id', $order->id)->delete();
            Order::destroy($order->id);
        });
    }
}
