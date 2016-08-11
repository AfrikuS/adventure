<?php

namespace App\Entities\Railway;

use App\Entities\ApplicationEntity;
use App\Models\Npc\ConductorSession;

class ConductorSessionEntity extends ApplicationEntity
{
    public function __construct(ConductorSession $meeting)
    {
        parent::__construct($meeting);
    }

    protected function getModelClass(): string
    {
        return ConductorSession::class;
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

    public function upperMood($points)
    {
        $summaryMood = $this->model->mood - $points;

        if ($summaryMood < 0) {
            $summaryMood = 0;
        }

        $this->model->mood = $summaryMood;
        $this->model->save();
    }
}
