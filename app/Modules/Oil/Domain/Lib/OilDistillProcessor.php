<?php

namespace App\Modules\Oil\Domain\Lib;

use App\Modules\Oil\Domain\Entities\OilDistiller;

class OilDistillProcessor
{
    public function process(OilDistiller $distiller)
    {
        return rand(5, 9);
    }
}
