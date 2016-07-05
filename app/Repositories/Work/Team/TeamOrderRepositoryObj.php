<?php

namespace App\Repositories\Work\Team;

use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\StateMachines\Work\TeamOrderEntity;

class TeamOrderRepositoryObj
{
    public function findOrderWithMaterialsAndSkillsById($id): TeamOrderEntity
    {
        $order = TeamOrder::select('id', 'price', 'status', 'desc', 'kind_work')
            ->with(['materials' => function ($query) {
                $query->select('id', 'teamorder_id', 'code', 'need', 'stock');
            }])
            ->with(['skills' => function ($query) {
                $query->select('id', 'teamorder_id', 'code', 'need_times', 'stock_times');
            }])
            ->find($id);

        return new TeamOrderEntity($order);
    }

    public function findSimpleOrderById($id): TeamOrderEntity
    {
        $order = TeamOrder::
            select(['id', 'desc', 'kind_work', 'price', 'acceptor_team_id', 'status' ])
            ->find($id);

        return new TeamOrderEntity($order);
    }

    public function getOrdersDrafts()
    {
        return TeamOrder::where('status', 'draft')->get();

    }

    public function createTeamOrderDraft()
    {
        return TeamOrder::create([
            'desc' => 'desc',
            'kind_work' => 'pokraska',
            'price' => 0,
            'acceptor_team_id' => null,
            'status' => 'draft',
        ]);
    }

}
