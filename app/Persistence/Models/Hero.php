<?php

namespace App\Persistence\Models;

class Hero extends DataObject
{

    public function incrementGold(int $amount)
    {
        $this->dataObject->gold += $amount;
    }

    protected function getAttributes()
    {
        return ['id', 'gold', 'oil', 'water'];
    }
}
