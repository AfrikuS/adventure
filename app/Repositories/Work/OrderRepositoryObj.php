<?php

namespace App\Repositories\Work;

use App\Factories\WorkerFactory;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\OrderSkill;
use App\Models\Work\Worker;
use App\Entities\Work\OrderEntity;

class OrderRepositoryObj
{
    public function getFreeOrders()
    {
        return Order::
            where('status', 'free')
            ->where('type', 'individual')
            ->get();
    }

    public function findSimpleOrderById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_worker_id', 'status', 'type'])
            ->find($id);

        return new OrderEntity($order);
//        return $order;
    }

    public function findOrderWithMaterialsById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_worker_id', 'status', 'type' ])
            ->where('type', 'individual')
            ->with('materials')
//            ->with('skills')
            ->find($id);

        return new OrderEntity($order);
    }

    public function createOrderModel($desc, $skillCode, $price)
    {
        return Order::create([
            'desc' => $desc,
            'kind_work_title' => $skillCode,
            'price' => $price,
            'acceptor_worker_id' => null,
            'acceptor_team_id' => null,
            'status' => 'free',
            'type' => 'individual',
        ]);

    }

    public function createMaterial($order_id, $code, $need)
    {
        return OrderMaterials::create([
            'order_id' => $order_id,
            'code' => $code,
            'need' => $need,
            'stock' => 0,
        ]);
    }

    public function createSkill($order_id, $code, $need)
    {
        return OrderSkill::create([
            'order_id' => $order_id,
            'code' => $code,
            'need_times' => $need,
            'stock_times' => 0,
        ]);

    }

}
