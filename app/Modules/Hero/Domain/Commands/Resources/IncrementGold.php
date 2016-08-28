<?php

namespace App\Modules\Hero\Domain\Commands\Resources;

class IncrementGold
{
    public $hero_id;
    
    public $amount;

    public function __construct($hero_id, $amount)
    {
        $this->hero_id = $hero_id;
        $this->amount = $amount;
    }
}
