<?php

namespace App\ViewData\Hero\Equipment;

class PumpOilDto
{
    public $level;

    public function __construct($level)
    {
        $this->level = $level;
    }


}
