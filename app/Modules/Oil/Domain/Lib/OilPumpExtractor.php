<?php

namespace App\Modules\Oil\Domain\Lib;

use App\Modules\Oil\Domain\Entities\OilPump;

class OilPumpExtractor
{
    public function process(OilPump $oilPump)
    {
        return rand(5, 9);
    }
}
