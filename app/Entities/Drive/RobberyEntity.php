<?php

namespace App\Entities\Drive;

use App\Entities\ApplicationEntity;
use App\Models\Drive\Raid;
use App\Models\Drive\Robbery;

class RobberyEntity extends ApplicationEntity
{
    public function __construct(Raid $raid)
    {
        parent::__construct($raid);
    }

    protected function getStatusAttribute ()
    {
        return $this->model->robbery_status;
    }

    protected function getModelClass(): string
    {
        return Raid::class;
    }

    protected function getStates(): array
    {
        return [
            'far_gates'               => ['type' => 'normal',  'properties' => []],
            'detailed_view_gates'     => ['type' => 'normal',  'properties' => []],
//            'drive_to_gates_wait'          => ['type' => 'normal',  'properties' => []],
            'gates'              => ['type' => 'normal',  'properties' => []],
//            'drive_gates_success'          => ['type' => 'normal',  'properties' => []],
        
            'fence'          => ['type' => 'normal',  'properties' => []],
//            'drive_in_fence_wait'          => ['type' => 'normal',  'properties' => []],
            'courtyard'      => ['type' => 'normal',  'properties' => []],

            'house'          => ['type' => 'normal',  'properties' => []],
            'ambar'          => ['type' => 'normal',  'properties' => []],
            'warehouse'      => ['type' => 'normal',  'properties' => []],

            'final'          => ['type' => 'final',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'drive_to_gates'          =>   ['from' => ['far_gates', 'detailed_view_gates'],  'to' => 'gates'],
            'detailed_view_on_gates'  =>   ['from' => ['far_gates'],    'to' => 'detailed_view_gates'],

            'drive_in_gates'          =>   ['from' => ['gates'],    'to' => 'fence'],
//            'drive_in_gates'          =>   ['from' => ['gates'],    'to' => 'fence'],
            'drive_in_fence'          =>   ['from' => ['fence'],    'to' => 'courtyard'],
//
            'drive_in_house'          =>   ['from' => ['courtyard'],    'to' => 'house'],
            'drive_in_ambar'          =>   ['from' => ['courtyard'],    'to' => 'ambar'],
            'drive_in_warehouse'      =>   ['from' => ['courtyard'],    'to' => 'warehouse'],
        ];
    }

    public function driveToGates()
    {
        if ($this->stateMachine->can('drive_to_gates')) {
            $this->stateMachine->apply('drive_to_gates');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

    public function detailedViewOnGates()
    {
        if ($this->stateMachine->can('detailed_view_on_gates')) {
            $this->stateMachine->apply('detailed_view_on_gates');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

    public function driveInGates()
    {
        if ($this->stateMachine->can('drive_in_gates')) {
            $this->stateMachine->apply('drive_in_gates');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

    public function driveInFence()
    {
        if ($this->stateMachine->can('drive_in_fence')) {
            $this->stateMachine->apply('drive_in_fence');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

    public function driveInAmbar()
    {
        if ($this->stateMachine->can('drive_in_ambar')) {
            $this->stateMachine->apply('drive_in_ambar');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

    public function driveInHouse()
    {
        if ($this->stateMachine->can('drive_in_house')) {
            $this->stateMachine->apply('drive_in_house');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

    public function driveInWarehouse()
    {
        if ($this->stateMachine->can('drive_in_warehouse')) {
            $this->stateMachine->apply('drive_in_warehouse');

            $this->model->update([
                'robbery_status' => $this->state,
            ]);
        }
    }

}
