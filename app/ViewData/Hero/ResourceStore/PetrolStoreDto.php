<?php

namespace App\ViewData\Hero\ResourceStore;

class PetrolStoreDto
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
