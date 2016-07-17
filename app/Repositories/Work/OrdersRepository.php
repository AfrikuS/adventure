<?php

namespace App\Repositories\Work;

use App\Models\Work\Order;

class OrdersRepository
{
    public function getAcceptedOrders($worker_id)
    {
        return Order::
            where('acceptor_worker_id', $worker_id)
            ->where('type', 'individual')
            ->get();
    }

    public function getFreeOrders()
    {
        return Order::
            where('status', 'free')
            ->where('type', 'individual')
            ->get();
    }


}
