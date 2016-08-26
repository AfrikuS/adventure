<?php

namespace App\ViewData\Hero\ResourceStore;

class OilStoreDto
{
    public $level;
    public $capacity;
    public $amount;

    public function __construct($level, $capacity, $amount)
    {
        $this->amount = $amount;
        $this->capacity = $capacity;
        $this->level = $level;
    }

}
