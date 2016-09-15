<?php

namespace App\Modules\Oil\Domain\Entities;

class OilPump
{
    const MAX_PUMP_LEVEL = 6;

    public $hero_id;
    public $level;

    public function __construct(\stdClass $oilPumpData)
    {
        $this->hero_id = $oilPumpData->hero_id;
        $this->level = $oilPumpData->level;
    }

    public function isFullUpgrade()
    {
        return $this->level >= self::MAX_PUMP_LEVEL;
    }

    public function upgradeLevel()
    {
        $this->level++;
    }
}
