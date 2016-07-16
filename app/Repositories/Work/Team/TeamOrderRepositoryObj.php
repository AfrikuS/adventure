<?php

namespace App\Repositories\Work\Team;

use App\Models\Work\Order;
use App\Entities\Work\TeamOrderDraftEntity;
use App\Entities\Work\TeamOrderEntity;

class TeamOrderRepositoryObj
{
    public function findOrderWithMaterialsAndSkillsById($id): TeamOrderEntity
    {
        $order = Order::select('id', 'price', 'status', 'desc', 'acceptor_team_id', 'type', 'acceptor_worker_id')
            ->with(['materials' => function ($query) {
                $query->select('id', 'order_id', 'code', 'need', 'stock');
            }])
            ->with(['skills' => function ($query) {
                $query->select('id', 'order_id', 'code', 'need_times', 'stock_times');
            }])
//            ->where('type', 'team')
            ->find($id);

        return new TeamOrderEntity($order);
    }

    public function findSimpleOrderById($id): TeamOrderEntity
    {
        $order = Order::
            select(['id', 'desc', 'price', 'acceptor_team_id', 'status', 'type'])
//            ->where('type', 'team')
            ->find($id);

        return new TeamOrderEntity($order);
    }

    public function getOrdersDrafts()
    {
        return Order::where('status', 'draft')->get();

    }

    public function createTeamOrderDraft()
    {
        return Order::create([
            'desc' => '',
            'kind_work_title' => '',
            'price' => 0,
            'acceptor_worker_id' => null,
            'acceptor_team_id' => null,
            'status' => 'draft',
            'type' => 'team',
        ]);
    }


    public function deleteOrderMaterials(TeamOrderDraftEntity $orderDraft)
    {
        $materials = $orderDraft->materials;
        foreach ($materials as $material) {
            $material->delete();
        }
        // todo review
//        $orderDraft->materials()->delete();

    }

    public function deleteOrderSkills(TeamOrderDraftEntity $orderDraft)
    {
        $skills = $orderDraft->skills;
        foreach ($skills as $skill) {
            $skill->delete();
        }
//        $orderDraft->skills()->delete();

    }

}
