<?php

namespace App\Entities\Drive;

use App\Entities\ApplicationEntity;
use App\Models\Drive\Detail;

class MountDetail extends ApplicationEntity
{
    public function __construct(Detail $detail)
    {
        parent::__construct($detail);
    }

    protected function getStatusAttribute()
    {
        return $this->model->mount_status;
    }
    
    protected function getModelClass(): string
    {
        return Detail::class;
    }

    protected function getStates(): array
    {
        return [
            'unmounted'   => ['type' => 'normal',  'properties' => []],
            'mounted'     => ['type' => 'normal',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'mount'    =>   ['from' => ['unmounted'],  'to' => 'mounted'],
            'unmount'  =>   ['from' => ['mounted'],    'to' => 'unmounted'],
        ];
    }

    public function mount($vehicle_id)
    {
        if ($this->stateMachine->can('mount')) {
            $this->stateMachine->apply('mount');

            $this->model->update([
                'vehicle_id' => $vehicle_id,
                'mount_status' => $this->state,
            ]);
        }
    }

    public function unmount()
    {
        if ($this->stateMachine->can('unmount')) {
            $this->stateMachine->apply('unmount');

            $this->model->update([
                'vehicle_id' => null,
                'mount_status' => $this->state,
            ]);
        }
    }

}
