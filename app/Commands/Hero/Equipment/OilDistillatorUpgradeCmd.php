<?php

namespace App\Commands\Hero\Equipment;

use App\Repositories\Core\Equipment\PumpOilRepo;

class OilDistillatorUpgradeCmd
{
    const MAX_OIL_DISTILLATOR_LEVEL    = 5;

    /** @var  PumpOilRepo */
    private $pumpOilRepo;

    public function __construct(PumpOilRepo $pumpOilRepo)
    {
        $this->pumpOilRepo = $pumpOilRepo;
    }

    public function upgrade($hero_id)
    {
        $oilDistillator = $this->pumpOilRepo->findOilDistillatorByHeroId($hero_id);


        $newLevel = $oilDistillator->oil_distillator_level + 1;


        if ($newLevel > self::MAX_OIL_DISTILLATOR_LEVEL) {

            throw new \Exception;
        }

        $oilDistillator->update([
            'oil_distillator_level'  => $newLevel,

        ]);

    }
}
