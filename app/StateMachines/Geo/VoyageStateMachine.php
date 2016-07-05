<?php

namespace App\StateMachines\Geo;

use App\Models\Geo\Voyage;
use App\StateMachines\StateMachineTrait;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

class VoyageStateMachine implements StatefulInterface
{
    use StateMachineTrait;

    /** @var Voyage $voyage */
    private $voyage;

    private $loader;

    public $state;
    /** @var StateMachine */
    public $stateMachine;

    public function __construct(Voyage $voyage)
    {
        $this->voyage = $voyage;
        $this->state = $voyage->status;

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
            'class'  => Voyage::class,
            'states' => [
                'ready_to_start' => ['type' => 'initial', 'properties' => []],
                'in_sail'        => ['type' => 'normal',   'properties' => []],
                'staying'        => ['type' => 'normal',   'properties' => []],
//                'trading'        => ['type' => 'normal', 'properties' => []],
                'finished'       => ['type' => 'final',   'properties' => []],
            ],
            'transitions' => [
                'begin'       =>  ['from' => ['ready_to_start'],   'to' => 'in_sail'],
                'moor'        =>  ['from' => ['in_sail'], 'to' => 'staying'],
//                'start_trade' =>  ['from' => ['in_sail'], 'to' => 'trading'],
                'sail_next'   =>  ['from' => ['staying'], 'to' => 'in_sail'],
                'finish'      =>  ['from' => ['staying'], 'to' => 'finished'],
            ]
        ]);

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }

    public function startVoyage()
    {
        if ($this->stateMachine->can('begin')) {
            $this->stateMachine->apply('begin');

            $this->voyage->update([
                'status' => $this->state,
            ]);
        }
    }

    public function moor()
    {
        if ($this->stateMachine->can('moor')) {
            $this->stateMachine->apply('moor');

            $this->voyage->update([
                'status' => $this->state,
            ]);
        }
    }


    public function sail_next()
    {
        if ($this->stateMachine->can('sail_next')) {
            $this->stateMachine->apply('sail_next');

            $this->voyage->update([
                'status' => $this->state,
//                'owner_id' => $owner->id,
            ]);
        }
    }

    public function finish()
    {
        if ($this->stateMachine->can('finish')) {
            $this->stateMachine->apply('finish');

            $this->voyage->update([
                'status' => $this->state,
            ]);
        }
    }
}
