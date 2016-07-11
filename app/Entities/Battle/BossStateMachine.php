<?php

use App\Models\Battle\Boss;
use App\Entities\StateMachineTrait;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

/** @deprecated  */ // todo review xz
class BossStateMachine implements StatefulInterface
{
    use StateMachineTrait;

    /** @var Boss $boss */
    private $boss;

    private $loader;

    public $state;
    /** @var StateMachine */
    public $stateMachine;

    public function __construct(Boss $boss)
    {
        $this->boss = $boss;
        $this->state = $boss->status;

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
            'class'  => Boss::class,
            'states' => [
                'NO_BOSS' => ['type' => 'initial', 'properties' => []],
                'BOSS_PROCESS'        => ['type' => 'normal',   'properties' => []],
                'BOSS_END'        => ['type' => 'normal',   'properties' => []],
//                'finished'       => ['type' => 'final',   'properties' => []],
            ],
            'transitions' => [
                'begin'       =>  ['from' => ['ready_to_start'],   'to' => 'in_sail'],
                'finish'      =>  ['from' => ['staying'], 'to' => 'finished'],
            ]
        ]);

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }

}
