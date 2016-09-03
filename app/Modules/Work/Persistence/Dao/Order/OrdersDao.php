<?php

namespace App\Modules\Work\Persistence\Dao\Order;

use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Entities\Order\OrderDraft;

class OrdersDao
{
    private $table = 'work_orders';

    public function find(int $id)
    {
        $order = \DB::table($this->table)
            ->select(['id', 'desc', 'type', 'status', 'domain_id', 'price',
                        'acceptor_worker_id', 'acceptor_team_id', 'customer_hero_id'])

            ->find($id);

        return $order;
    }
    
    public function create($desc, $domain_id, $price, $customer_id, $status, $type)
    {
        $order_id = \DB::table($this->table)->insertGetId([
            'desc' => $desc,
            'domain_id' => $domain_id,
            'price' => $price,
            'acceptor_worker_id' => null,
            'acceptor_team_id' => null,
            'status' => $status,
            'type' => $type,
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

    public function getFreeOrders()
    {
        $orders =
            \DB::table($this->table . ' AS o')
                ->select(['o.id', 'o.price', 'o.status', 'do.title AS domain_title'])
                ->join('employment_domains AS do', 'do.id', '=', 'o.domain_id')
                ->where('status', Order::STATUS_FREE)
                ->where('type', Order::TYPE_INDIVIDUAL)
                ->get();

        return $orders;
    }

    public function getAcceptedOrders($worker_id)
    {
        $orders = \DB::table($this->table . ' AS o')
            ->select(['o.id', 'o.price', 'o.status', 'do.title AS domain_title'])
            ->join('employment_domains AS do', 'do.id', '=', 'o.domain_id')
            ->where('type', Order::TYPE_INDIVIDUAL)
            ->where('acceptor_worker_id', $worker_id)
            ->get();

        return $orders;
    }

    public function update($id, $status, $acceptor_worker_id)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'status' => $status,
                'acceptor_worker_id' => $acceptor_worker_id,
            ]);
    }

    public function getDrafts()
    {
        $orders =
            \DB::table($this->table . ' AS o')
                ->select(['o.id', 'o.price', 'o.status', 'do.title AS domain_title',
                     'o.desc', 'o.type', 'o.domain_id', 'o.customer_hero_id'])
                ->join('employment_domains AS do', 'do.id', '=', 'o.domain_id')
                ->where('status', OrderDraft::STATUS_DRAFT)
//                ->where('type', Order::TYPE_INDIVIDUAL)
                ->get();

        return $orders;
    }

    public function updateData($id, $desc, $price)
    {
        return
            \DB::table($this->table)
                ->where('id', $id)
                ->update([
                    'desc' => $desc,
                    'price' => $price,
                ]);
    }
}
