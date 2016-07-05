<?php

namespace App\StateMachines\Trade;

use App\Models\Core\Thing;
use App\StateMachines\ApplicationEntity;
use App\StateMachines\StateMachineTrait;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

class ThingStateMachine extends ApplicationEntity
{
    public function __construct(Thing $thing)
    {
        parent::__construct($thing);
    }

    protected function getModelClass(): string
    {
        return Thing::class;
    }

    protected function getStates(): array
    {
        return [
            'free'         => ['type' => 'initial', 'properties' => []],
            'locked'       => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'lock'  =>   ['from' => ['free'],   'to' => 'locked'],
            'unlock' =>  ['from' => ['locked'], 'to' => 'free'],
        ];
    }

    public function lock()
    {
        if ($this->stateMachine->can('lock')) {
            $this->stateMachine->apply('lock');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }

    public function changeOwner($owner_id)
    {
        if ($this->stateMachine->can('unlock')) {
            
            $this->model->update([
                'owner_id' => $owner_id,
            ]);
        }        
    }

    public function unlock()
    {
        if ($this->stateMachine->can('unlock')) {
            $this->stateMachine->apply('unlock');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }
}
