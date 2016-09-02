<?php

namespace App\Modules\Oil\Domain\Entities;

class OilStore
{
    public $hero_id;
    public $capacityLevel;
    public $capacity;
    public $amount;

    public function __construct(\stdClass $oilPumpData)
    {
        $this->hero_id = $oilPumpData->hero_id;
        $this->capacityLevel = $oilPumpData->capacityLevel;
        $this->capacity = $oilPumpData->capacity;
        $this->amount = $oilPumpData->amount;
    }
}
