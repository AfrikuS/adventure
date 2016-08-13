<?php

namespace App\Persistence\Dao\Work;

use App\Persistence\Models\Work\Order;

class OrderDao
{
    private $table = 'work_orders';

    public function findById(int $id)
    {
        $order = \DB::table($this->table)
            ->select(['id', 'desc', 'type', 'status', 'kind_work_title', 'price',
                        'acceptor_worker_id', 'acceptor_team_id', 'customer_hero_id'])

            ->find($id);

        return $order;
    }

    public function save(Order $order)
    {
        if ($order->id != null) {

            \DB::table($this->table)
                ->where('id', $order->id)
                ->update([
                    'status'  => $order->status,
                    'acceptor_worker_id'   => $order->acceptor_worker_id,
                ]);
        }
    }

    public function create($desc, $skillCode, $price, $customer_id)
    {
        $order_id = \DB::table($this->table)->insertGetId([
            'desc' => $desc,
            'kind_work_title' => $skillCode,
            'price' => $price,
            'acceptor_worker_id' => null,
            'acceptor_team_id' => null,
            'status' => 'free',
            'type' => 'individual',
            'customer_hero_id' => $customer_id,
        ]);

        return $order_id;
    }

    public function delete($order_id)
    {
        \DB::table('work_orders')
            ->where('id', $order_id)
            ->delete();
    }

}
