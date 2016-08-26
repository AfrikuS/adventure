<?php

namespace App\Modules\Hero\Domain\Commands\Resources;

class IncrementGold
{
    public $hero_id;
    
    public $amount;

    /**
     * IncrementGold constructor.
     * @param $hero_id
     * @param $amount
     */
    public function __construct($hero_id, $amount)
    {
        $this->hero_id = $hero_id;
        $this->amount = $amount;
    }
}
