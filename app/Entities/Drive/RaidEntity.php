<?php

namespace App\Entities\Drive;

use App\Entities\ApplicationEntity;
use App\Models\Drive\Raid;

class RaidEntity extends ApplicationEntity
{
    public function __construct(Raid $raid)
    {
        parent::__construct($raid);
    }

    public function isRobberyExist()
    {
        return $this->model->robbery_status != null;
    }

    public function isVictimNotFinded()
    {
        return $this->model->victim_id === null;
    }

    public function addReward($goldAmount)
    {
        $this->model->increment('reward', $goldAmount);
    }

    protected function getModelClass(): string
    {
        return Raid::class;
    }

    protected function getStates(): array
    {
        return [
            'switch_action'   => ['type' => 'normal',  'properties' => []],
            'repair'          => ['type' => 'normal',  'properties' => []],
            'search_victim'   => ['type' => 'normal',  'properties' => []],
            'in_robbery'      => ['type' => 'normal',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'start_search'   =>   ['from' => ['switch_action', 'search_victim'],    'to' => 'search_victim'],

            'to_pitstop'     =>   ['from' => ['switch_action'],    'to' => 'repair'],
            'to_robbery'     =>   ['from' => ['search_victim'],    'to' => 'in_robbery'],
            'complete_robbery' =>   ['from' => ['in_robbery'],       'to' => 'switch_action'],
        ];
    }

    public function startRaid()
    {
        if ($this->stateMachine->can('start_search')) {
            $this->stateMachine->apply('start_search');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }
//
//    public function startSearch()
//    {
//        if ($this->stateMachine->can('start_search')) {
//            $this->stateMachine->apply('start_search');
//
//            $this->model->update([
//                'status' => $this->state,
//            ]);
//        }
//    }

    public function findVictim($victim_id)
    {
        if ($this->stateMachine->can('start_search')) {
            $this->stateMachine->apply('start_search');

            $this->model->update([
                'status' => $this->state,
                'victim_id' => $victim_id,
            ]);
        }
    }

    public function notFindVictim()
    {
        $this->model->update([
            'victim_id' => null,
        ]);
    }


    public function toRobberyOnVictim()
    {
        if ($this->stateMachine->can('to_robbery')) {
            $this->stateMachine->apply('to_robbery');

            $this->model->update([
                'status' => $this->state,
                'robbery_status' => 'fence', //'far_gates',
            ]);
        }
    }

    public function toPitStop()
    {
        if ($this->stateMachine->can('to_pitstop')) {
            $this->stateMachine->apply('to_pitstop');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }

    public function completeRobbery()
    {
        if ($this->stateMachine->can('complete_robbery')) {
            $this->stateMachine->apply('complete_robbery');

            $this->model->update([
                'status' => $this->state,
            ]);
        }
    }
    
    
}
