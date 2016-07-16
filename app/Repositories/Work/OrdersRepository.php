<?php

namespace App\Repositories;

use App\Models\Work\Order;

class OrdersRepository
{
    public function getAcceptedOrders($worker_id)
    {
        return Order::where('acceptor_worker_id', $worker_id)->get();
    }

    public function getFreeOrders()
    {
        return Order::
            where('status', 'free')
            ->where('type', 'individual')
            ->get();
    }


}
