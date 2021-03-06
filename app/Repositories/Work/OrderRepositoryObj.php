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
    public function findSimpleOrderById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 
                    'acceptor_worker_id', 'status', 'type', 'customer_hero_id'])
            ->find($id);

        return new OrderEntity($order);
    }

    public function findOrderWithMaterialsById($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_worker_id', 'status', 'type' ])
            ->where('type', 'individual')
            ->with('materials')
            ->find($id);

        return new OrderEntity($order);
    }

    public function createOrderModel($desc, $skillCode, $price, $customer_id)
    {
        $order = Order::create([
            'desc' => $desc,
            'kind_work_title' => $skillCode,
            'price' => $price,
            'acceptor_worker_id' => null,
            'acceptor_team_id' => null,
            'status' => 'free',
            'type' => 'individual',
            'customer_hero_id' => $customer_id,
        ]);

        return new OrderEntity($order);
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
