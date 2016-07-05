<?php

namespace App\StateMachines\Work;

use App\Models\Work\Team\TeamOrder;
use App\StateMachines\ApplicationEntity;

class TeamOrderDraftEntity extends ApplicationEntity
{
    public function __construct(TeamOrder $order)
    {
        parent::__construct($order);
    }

    protected function getModelClass(): string
    {
        return TeamOrder::class;
    }

    protected function getStates(): array
    {
        return [
            'draft'            => ['type' => 'initial', 'properties' => []],
//            'accepted'        => ['type' => 'normal',  'properties' => []],
//            'stock_materials' => ['type' => 'normal',  'properties' => []],
//            'stock_skills'    => ['type' => 'normal',  'properties' => []],
            'free'       => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'finish'  =>                ['from' => ['draft'],            'to' => 'free'],
//            'estimate'  =>              ['from' => ['accepted'],        'to' => 'stock_materials'],
//            'finish_stock_materials' => ['from' => ['stock_materials'], 'to' => 'stock_skills'],
//            'finish_stock_skills'  =>   ['from' => ['stock_skills'],    'to' => 'completed'],
        ];
    }
}
