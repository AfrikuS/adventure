<?php

namespace App\Entities\Hero;

use App\Entities\ApplicationEntity;
use App\Models\Core\Buildings;
use App\Models\Drive\Driver;

class BuildingsEntity extends ApplicationEntity
{
    public function __construct(Buildings $buildings)
    {
        parent::__construct($buildings);
    }

    protected function getModelClass(): string
    {
        return Driver::class;
    }

    protected function getStates(): array
    {
        return [
            'normal' => ['type' => 'initial',  'properties' => []],
            'full'   => ['type' => 'normal',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'start_raid'   =>   ['from' => ['free'],     'to' => 'in_raid'],
            'finish_raid'  =>   ['from' => ['in_raid'],  'to' => 'free'],

        ];
    }
}
