<?php

namespace App\Repositories\Work;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\TeamWorker;

class OrderRepository
{
    public static function isOrderReadyToWorks(Order $order)
    {
        return $order->status === 'ready_to_work';
    }

    public static function getOrderById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ])
            ->find($id);

        return $order;
    }

    // with materials
    public static function deleteOrder(Order $order)
    {
        OrderMaterials::where('order_id', $order->id)->delete();
        Order::destroy($order->id);
    }

    public static function startWorks(Order $order): void
    {
        $order->update(['status' => 'working']);
    }

    public static function finishWorks(Order $order): void
    {
        $order->update(['status' => 'finished']);
    }

    public static function orderReadyToWork(Order $order): bool
    {
        return OrderMaterials::select('id')->where('order_id', $order->id)->count() == 0; // todo raw-count() ?
    }

    public static function isOrderAcceptor(Order $order, TeamWorker $worker)
    {
        return $order && $order->acceptor_user_id == $worker->id;
    }
}
