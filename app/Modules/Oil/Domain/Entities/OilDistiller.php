<?php

namespace App\Modules\Oil\Domain\Entities;

class OilDistiller
{
    const MAX_DISTILLER_LEVEL = 6;

    public $hero_id;
    public $level;

    public function __construct(\stdClass $oilDistillerData)
    {
        $this->hero_id = $oilDistillerData->hero_id;
        $this->level = $oilDistillerData->level;
    }

    public function isFullUpgrade()
    {
        return $this->level >= self::MAX_DISTILLER_LEVEL;
    }

    public function upgradeLevel()
    {
        $this->level++;
    }
}
