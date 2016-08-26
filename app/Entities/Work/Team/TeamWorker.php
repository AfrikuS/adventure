<?php

namespace App\Entities\Work\Team;

use App\Entities\ApplicationEntity;
use App\Models\Work\Worker;

class TeamWorker extends ApplicationEntity
{
    public function __construct(Worker $worker)
    {
        parent::__construct($worker);
    }

    protected function getModelClass(): string
    {
        return Worker::class;
    }

    protected function getStates(): array
    {
        return [
            'free'          => ['type' => 'initial', 'properties' => []],
            'joined'        => ['type' => 'normal', 'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'join'  =>                ['from' => ['free'],            'to' => 'joined'],
            'left_team'  =>           ['from' => ['joined'],          'to' => 'free'],
        ];
    }

    public function joinToTeam($team_id)
    {
        if ($this->stateMachine->can('join')) {
            $this->stateMachine->apply('join');

            $this->model->update([
                'status'  => $this->state,
                'team_id' => $team_id,
            ]);
        }
    }

    public function leftTeam()
    {
        if ($this->stateMachine->can('left_team')) {
            $this->stateMachine->apply('left_team');

            $this->model->update([
                'status' => $this->state,
                'team_id' => null,
            ]);
        }
    }
}
