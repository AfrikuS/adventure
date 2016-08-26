<?php

namespace App\Entities\Npc;

use App\Entities\ApplicationEntity;
use App\Helpers\TimeHelper;
use App\Models\Npc\NpcDeal;
use Carbon\Carbon;

class NpcOfferEntity extends ApplicationEntity
{
    public function __construct(NpcDeal $deal)
    {
        parent::__construct($deal);
    }

    protected function getStatusAttribute ()
    {
        return $this->model->offer_status;
    }


    protected function getModelClass(): string
    {
        return NpcDeal::class;
    }

    protected function getStates(): array
    {
        return [
            'created'     => ['type' => 'initial', 'properties' => []],
            'shown'       => ['type' => 'normal', 'properties' => []],
            'accepted'    => ['type' => 'final', 'properties' => []],
            'refused'     => ['type' => 'final', 'properties' => []],
            'expired'     => ['type' => 'final', 'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'show'    =>   ['from' => ['created'], 'to' => 'shown'],
            'accept'  =>   ['from' => ['shown'],   'to' => 'accepted'],
            'refuse'  =>   ['from' => ['shown'],   'to' => 'refused'],
            'too_long_wait'  =>   ['from' => ['shown'],   'to' => 'expired'],
        ];
    }

    public function show(Carbon $offerEnding)
    {
        if ($this->stateMachine->can('show')) {
            $this->stateMachine->apply('show');
            
            $this->model->update([
                'offer_status' => $this->state,
                'offer_ending' => $offerEnding->toDateTimeString(),
            ]);
        }
    }

    public function tooLongWait()
    {
        if ($this->stateMachine->can('too_long_wait')) {
            $this->stateMachine->apply('too_long_wait');

            $this->model->update([
                'offer_status' => $this->state,
            ]);
        }
    }

    public function isOfferExpired()
    {
        if ($this->state == 'expired') {
            return true;
        }
        
        $leftSeconds = TimeHelper::leftSecs($this->model->offer_ending);
        
        return $leftSeconds <= 0;
    }

    public function accept(Carbon $dealEnding)
    {
        if ($this->stateMachine->can('accept')) {
            $this->stateMachine->apply('accept');
            
            $this->model->update([
                'offer_status' => $this->state,
                'deal_status' => 'started',
                'deal_ending' => $dealEnding->toDateTimeString(),
            ]);
        }
    }

    public function refuse()
    {
        if ($this->stateMachine->can('refuse')) {
            $this->stateMachine->apply('refuse');

            $this->model->update([
                'offer_status' => $this->state,
            ]);
        }
    }

}
