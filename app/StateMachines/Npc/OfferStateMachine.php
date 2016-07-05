<?php

namespace App\StateMachines\Npc;

use App\Models\Npc\NpcDeal;
use App\StateMachines\StateMachineTrait;
use Carbon\Carbon;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;

class OfferStateMachine implements StatefulInterface
{
    use StateMachineTrait;

    /** @var NpcDeal $offer */
    private $offer;

    /** @var StateMachine */
    public $stateMachine;

    public function __construct(NpcDeal $offer)
    {
        $this->offer = $offer;
        $this->state = $offer->offer_status;

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
                'created'     => ['type' => 'initial', 'properties' => []],
                'shown'       => ['type' => 'normal', 'properties' => []],
                'accepted'    => ['type' => 'final', 'properties' => []],
                'refused'     => ['type' => 'final', 'properties' => []],
                'expired'    => ['type' => 'final', 'properties' => []],
            ],
            'transitions' => [
                'show'    =>   ['from' => ['created'], 'to' => 'shown'],
                'accept'  =>   ['from' => ['shown'],   'to' => 'accepted'],
                'refuse'  =>   ['from' => ['shown'],   'to' => 'refused'],
                'too_long_wait'  =>   ['from' => ['shown'],   'to' => 'expired'],
            ]
        ]);

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }

    public function show()
    {
        if ($this->stateMachine->can('show')) {
            $this->stateMachine->apply('show');
            $offerEnding = Carbon::create()->addHours(2)->toDateTimeString();
            
            $this->offer->update([
                'offer_status' => $this->state,
                'offer_ending' => $offerEnding,
            ]);
        }
    }

    public function tooLongWait()
    {
        if ($this->stateMachine->can('too_long_wait')) {
            $this->stateMachine->apply('too_long_wait');

            $this->offer->update([
                'offer_status' => $this->state,
            ]);
        }
        
    }

    public function accept()
    {
        if ($this->stateMachine->can('accept')) {
            $this->stateMachine->apply('accept');
            $dealEnding = Carbon::create()->addHours(24)->toDateTimeString();
            
            $this->offer->update([
                'offer_status' => $this->state,
                'deal_status' => 'started',
                'deal_ending' => $dealEnding,
            ]);
        }
    }

    public function refuse()
    {
        if ($this->stateMachine->can('refuse')) {
            $this->stateMachine->apply('refuse');

            $this->offer->update([
                'offer_status' => $this->state,
            ]);
        }
    }
}
