<?php

namespace App\Repositories\Work;

use App\Models\Work\Order;
use Illuminate\Database\Eloquent\Collection;

class TeamOrdersRepository
{
    public function getFreeTeamOrders(): Collection
    {
        return Order::
            select('id', 'desc', 'kind_work_title', 'price', 'acceptor_worker_id', 'acceptor_team_id', 'status', 'type')
            ->where('type', 'team')
            ->whereAnd('status', 'free')
            ->get();
    }

    public function getTeamOrdersByTeamId($team_id)
    {
        return Order::
            select('id', 'desc', 'kind_work_title', 'price', 'acceptor_worker_id', 'acceptor_team_id', 'status', 'type')
            ->where('type', 'team')
            ->where('acceptor_team_id', $team_id)
//            ->where('status', 'free')
            ->get();
    }
}
