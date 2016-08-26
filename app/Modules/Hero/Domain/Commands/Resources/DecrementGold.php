<?php

namespace App\Modules\Hero\Domain\Commands\Resources;

class DecrementGold
{
    public $hero_id;
    
    public $amount;

    /**
     * DecrementGold constructor.
     * @param $hero_id
     * @param $amount
     */
    public function __construct($hero_id, $amount)
    {
        $this->hero_id = $hero_id;
        $this->amount = $amount;
    }
}
