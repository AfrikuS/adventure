<?php

namespace App\Repositories\Work;

use App\Entities\Work\TeamOrderDraftEntity;
use App\Models\Work\Order;

class TeamOrderDraftRepo
{
    public function findOrderDraft($draft_id)
    {
        $order = Order::select('id', 'price', 'status', 'desc', 'kind_work_title')
            ->with(['materials' => function ($query) {
                $query->select('id', 'order_id', 'code', 'need', 'stock');
            }])
            ->with(['skills' => function ($query) {
                $query->select('id', 'order_id', 'code', 'need_times', 'stock_times');
            }])
            ->find($draft_id);

        return new TeamOrderDraftEntity($order);
    }

}
