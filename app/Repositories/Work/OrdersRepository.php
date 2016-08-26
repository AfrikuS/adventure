<?php

namespace App\Repositories\Work;

use App\Models\Work\Order;

/** @deprecated  */
class OrdersRepository
{
    /** @deprecated  */
    public function getAcceptedOrders($worker_id)
    {
        return Order::
            where('acceptor_worker_id', $worker_id)
            ->where('type', 'individual')
            ->get();
    }

    /** @deprecated  */
    public function getFreeOrders()
    {
        return Order::
            where('status', 'free')
            ->where('type', 'individual')
            ->get();
    }


}
