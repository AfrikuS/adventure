<?php

namespace App\StateMachines\Npc;

use App\Models\Npc\NpcDeal;
use App\StateMachines\StateMachineTrait;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

class DealStateMachine  implements StatefulInterface
{
    use StateMachineTrait;

    /** @var NpcDeal $deal */
    private $deal;

    /** @var StateMachine */
    public $stateMachine;

    public function __construct(NpcDeal $deal)
    {
        $this->deal = $deal;
        $this->state = $deal->deal_status;

        $this->initStatesTransitions();
    }

    public function getSM()
    {
        return $this->stateMachine;
    }

    private function initStatesTransitions()
    {
        $this->stateMachine = new StateMachine;
        $this->loader       = new ArrayLoader([
            'class'  => NpcDeal::class,
            'states' => [
                'started'       => ['type' => 'initial', 'properties' => []],
                'finished'      => ['type' => 'final',   'properties' => []],
                'expired'       => ['type' => 'final',   'properties' => []],
            ],
            'transitions' => [
                'perform_task'  =>  ['from' => ['started'], 'to' => 'finished'],
                'too_long_time' =>  ['from' => ['started'], 'to' => 'expired'],
            ]
        ]);

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
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
