<?php

namespace App\Entities\Hero;

use App\Entities\ApplicationEntity;
use App\Exceptions\NotEnoughResourceException;
use App\Models\Core\Hero;

class HeroEntity extends ApplicationEntity
{
    public function __construct(Hero $hero)
    {
        parent::__construct($hero);
    }

    protected function getModelClass(): string
    {
        return Hero::class;
    }

    protected function getStates(): array
    {
        return [
            'normal' => ['type' => 'initial',  'properties' => []],
            'final'   => ['type' => 'final',  'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'transfer'   =>   ['from' => ['normal'],     'to' => 'final'],
        ];
    }

    public function incrOil($amount)
    {
        $result = $this->model->oil + $amount;

        $this->model->update([
            'oil' => $result,
        ]);
    }

    public function decrOil($amount)
    {
        $result = $this->model->oil - $amount;
        
        if ($result < 0) {
            throw new NotEnoughResourceException;
        }
        
        $this->model->update([
            'oil' => $result,
        ]);
    }

    public function incrWater($amount)
    {
        $result = $this->model->water + $amount;

        $this->model->update([
            'water' => $result,
        ]);
    }

    public function decrWater($amount)
    {
        $result = $this->model->water - $amount;
        
        if ($result < 0) {
            throw new NotEnoughResourceException;
        }
        
        $this->model->update([
            'water' => $result,
        ]);
    }

    public function incrGold($amount)
    {
        $result = $this->model->gold + $amount;

        $this->model->update([
            'gold' => $result,
        ]);
    }

    public function decrGold($amount)
    {
        $result = $this->model->gold - $amount;
        
        if ($result < 0) {
            throw new NotEnoughResourceException;
        }
        
        $this->model->update([
            'gold' => $result,
        ]);
    }

}
