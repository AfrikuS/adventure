<?php

namespace App\Entities\Drive;

use App\Entities\ApplicationEntity;
use App\Models\Drive\Vehicle;

class RaidVehicle extends ApplicationEntity
{

    public function __construct(Vehicle $vehicle)
    {
        parent::__construct($vehicle);
    }

    public function makeDamage(int $damage)
    {
        $summaryDamage = $this->model->damage_percent + $damage;
        
        if ($summaryDamage >= 100) {
            $summaryDamage = 100;

            $this->stateMachine->apply('break');
        }

        $this->model->update([
            'damage_percent' => $summaryDamage,
            'status' => $this->state,
        ]);
    }

    public function repairOn($amount)
    {
        $summaryDamage = $this->model->damage_percent - $amount;
        
        if ($summaryDamage < 0) {
            $summaryDamage = 0;
        }

        $this->model->update([
            'status' => $this->state,
            'damage_percent' => $summaryDamage,
        ]);
    }

    public function recoveryAfterBreaking()
    {
        if ($this->stateMachine->can('recovery')) {
            $this->stateMachine->apply('recovery');

            $this->model->update([
                'status' => $this->state,
                'damage_percent' => 80,
            ]);
            
        }
    }

    public function refuel($amount)
    {
        $this->model->increment('fuel_level', $amount);
    }

    protected function getModelClass(): string
    {
        return Vehicle::class;
    }

    protected function getStates(): array
    {
        return [
            'normal'   => ['type' => 'normal',  'properties' => []],
            'broken'   => ['type' => 'normal',  'properties' => []],
//            'in_robbery'      => ['type' => 'normal',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'break'     =>   ['from' => ['normal'],    'to' => 'broken'],
            'recovery'  =>   ['from' => ['broken'],    'to' => 'normal'],
        ];
    }
}
