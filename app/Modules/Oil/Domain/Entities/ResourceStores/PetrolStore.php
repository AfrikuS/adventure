<?php

namespace App\ViewData\Hero\ResourceStore;

class PetrolStore
{
    public $hero_id;
    public $level;
    public $capacity;
    public $amount;

    public function __construct(\stdClass $oilStoreData)
    {
        $this->hero_id = $oilStoreData->hero_id;
        $this->amount = $oilStoreData->amount;
        $this->capacity = $oilStoreData->capacity;
        $this->level = $oilStoreData->level;
    }
}
