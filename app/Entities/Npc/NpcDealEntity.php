<?php

namespace App\Entities\Npc;

use App\Entities\ApplicationEntity;
use App\Models\Npc\NpcDeal;

class NpcDealEntity extends ApplicationEntity
{
    public function __construct(NpcDeal $deal)
    {
        parent::__construct($deal);
    }

    protected function getModelClass(): string
    {
        return NpcDeal::class;
    }

    protected function getStates(): array
    {
        return [
            'started'       => ['type' => 'initial', 'properties' => []],
            'finished'      => ['type' => 'final',   'properties' => []],
            'expired'       => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'perform_task'  =>  ['from' => ['started'], 'to' => 'finished'],
            'too_long_time' =>  ['from' => ['started'], 'to' => 'expired'],
        ];
    }

    public function performTask()
    {
        if ($this->stateMachine->can('perform_task')) {
            $this->stateMachine->apply('perform_task');

            $this->deal->update([
                'deal_status' => $this->state,
            ]);
        }
    }

    public function tooLongTime()
    {
        if ($this->stateMachine->can('too_long_time')) {
            $this->stateMachine->apply('too_long_time');

            $this->deal->update([
                'deal_status' => $this->state,
            ]);
        }
    }

}
