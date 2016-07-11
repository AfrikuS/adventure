<?php

namespace App\Entities\Work;

use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Worker;
use App\Entities\StateMachineTrait;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

class WorkerStateMachine implements StatefulInterface
{
    use StateMachineTrait;

    /** @var Worker $worker */
    private $worker;

    /** @var StateMachine */
    protected $stateMachine;

    public function __construct(Worker $worker)
    {
        $this->offer = $worker;
        $this->state = $worker->offer_status;

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
            'class'  => Worker::class,
            'states' => [
//                'created'     => ['type' => 'initial', 'properties' => []],
//                'shown'       => ['type' => 'normal', 'properties' => []],
//                'expired'    => ['type' => 'final', 'properties' => []],
            ],
            'transitions' => [
//                'show'    =>   ['from' => ['created'], 'to' => 'shown'],
//                'accept'  =>   ['from' => ['shown'],   'to' => 'accepted'],
//                'refuse'  =>   ['from' => ['shown'],   'to' => 'refused'],
//                'too_long_wait'  =>   ['from' => ['shown'],   'to' => 'expired'],
            ]
        ]);

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }

    public function isHaveTeam()
    {
        return is_int($this->worker->team_id);
    }
    
    public function isBelongTeam($team_id)
    {
        return $this->isHaveTeam() && ($this->worker->team_id == $team_id);
    }

    public function isLeaderOfTeam(PrivateTeam $team)
    {
        return $this->worker->id == $team->leader_worker_id;
    }

}
