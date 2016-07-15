<?php

namespace App\Entities\Drive;

use App\Entities\ApplicationEntity;
use App\Models\Drive\Driver;

class DriverEntity extends ApplicationEntity
{
    public function __construct(Driver $driver)
    {
        parent::__construct($driver);
    }

    protected function getModelClass(): string
    {
        return Driver::class;
    }

    protected function getStates(): array
    {
        return [
            'free'      => ['type' => 'initial',  'properties' => []],
            'in_raid'   => ['type' => 'normal',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'start_raid'   =>   ['from' => ['free'],     'to' => 'in_raid'],
            'finish_raid'  =>   ['from' => ['in_raid'],  'to' => 'free'],
            
        ];
    }

    public function startRaid()
    {
        if ($this->stateMachine->can('start_raid')) {
            $this->stateMachine->apply('start_raid');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }

    public function finishRaid()
    {
        if ($this->stateMachine->can('finish_raid')) {
            $this->stateMachine->apply('finish_raid');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }
}
