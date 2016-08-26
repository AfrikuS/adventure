<?php

namespace App\Modules\Hero\Domain\Entities;

use App\Exceptions\NotEnoughResourceException;
use App\Persistence\Models\DataObject;

class Hero
{
    public $id;
    public $gold;
    public $oil;
    public $water;

    public function __construct(\stdClass $heroData)
    {
        $this->id = $heroData->id;
        $this->gold = $heroData->gold;
        $this->oil = $heroData->oil;
        $this->water = $heroData->water;
    }

    public function incrementGold(int $amount)
    {
        $this->gold += $amount;
    }

    public function decrementGold(int $amount)
    {
        if ($this->gold < $amount) {
            
            throw new NotEnoughResourceException;
        }

        $this->gold -= $amount;
    }
}
