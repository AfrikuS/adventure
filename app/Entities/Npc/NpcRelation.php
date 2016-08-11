<?php

namespace App\Entities\Npc;

use App\Entities\ApplicationEntity;
use App\Models\Npc\HeroConductorRelation;

class NpcRelation extends ApplicationEntity
{
    public function __construct(HeroConductorRelation $heroRelation)
    {
        parent::__construct($heroRelation);
    }

    protected function getModelClass(): string
    {
        return HeroConductorRelation::class;
    }

    protected function getStates(): array
    {
        return [
            'started'       => ['type' => 'initial', 'properties' => []],
            'finished'      => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'begin'  =>  ['from' => ['started'], 'to' => 'finished'],
        ];
    }

    public function upReputation($points)
    {
        $this->model->increment('respect_level', $points);

    }
}
