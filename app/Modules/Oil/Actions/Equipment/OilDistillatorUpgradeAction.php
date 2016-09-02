<?php

namespace App\Modules\Oil\Actions\Equipment;

use App\Repositories\Core\Equipment\OilPumpRepo;

class OilDistillatorUpgradeAction
{
    const MAX_OIL_DISTILLATOR_LEVEL    = 5;

    /** @var  OilPumpRepo */
    private $pumpOilRepo;

    public function __construct(OilPumpRepo $pumpOilRepo)
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
