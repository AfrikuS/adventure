<?php

namespace App\Repositories\Work;

use App\Factories\WorkerFactory;
use App\Models\Work\Order;
use App\Models\Work\Worker;
use App\StateMachines\Work\OrderStateMachine;

class OrderRepositoryObj
{
    public function getFreeOrders()
    {
        return Order::where('status', 'free')->get();
    }

    public function findSimpleOrderById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ])
            ->find($id);

        return new OrderStateMachine($order);
//        return $order;
    }

    public function findOrderWithMaterialsById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ])
            ->with('materials')
//            ->with('skills')
            ->find($id);

        return new OrderStateMachine($order);
    }


}
