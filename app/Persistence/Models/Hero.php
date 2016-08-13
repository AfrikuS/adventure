<?php

namespace App\Persistence\Models;

use App\Exceptions\NotEnoughResourceException;

class Hero extends DataObject
{

    public function incrementGold(int $amount)
    {
        $this->dataObject->gold += $amount;
    }

    public function decrementGold(int $amount)
    {
        if ($this->dataObject->gold < $amount) {
            throw new NotEnoughResourceException;
        }

        $this->dataObject->gold -= $amount;
    }

    protected function getAttributes()
    {
        return ['id', 'gold', 'oil', 'water'];
    }
}
