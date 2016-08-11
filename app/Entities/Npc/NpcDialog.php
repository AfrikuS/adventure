<?php

namespace App\Entities\Npc;

use App\Entities\ApplicationEntity;

class NpcDialog extends ApplicationEntity
{
    public function __construct(Dialog $dialog)
    {
        parent::__construct($dialog);
    }

    protected function getModelClass(): string
    {
        return Dialog::class;
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
            'welcome' =>  ['from' => ['started'], 'to' => 'expired'],
            'laugh'  =>  ['from' => ['started'], 'to' => 'finished'],
            'bargain_offer'  =>  ['from' => ['started'], 'to' => 'finished'],
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

}
