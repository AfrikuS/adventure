<?php

namespace App\ViewData\Hero\Equipment;

class OilDistillatorDto
{
    public $level;

    public function __construct($level)
    {
        $this->level = $level;
    }
}
