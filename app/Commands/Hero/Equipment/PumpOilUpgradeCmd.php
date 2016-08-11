<?php

namespace App\Commands\Hero\Equipment;

use App\Repositories\Core\Equipment\PumpOilRepo;

class PumpOilUpgradeCmd
{
    const MAX_PUMP_OIL_LEVEL    = 4;

    /** @var  PumpOilRepo */
    private $pumpOilRepo;

    public function __construct(PumpOilRepo $pumpOilRepo)
    {
        $this->pumpOilRepo = $pumpOilRepo;
    }

    public function upgrade($hero_id)
    {
        $pumpOil = $this->pumpOilRepo->findPumpOilByHeroId($hero_id);


        $newLevel = $pumpOil->pump_level + 1;


        if ($newLevel > self::MAX_PUMP_OIL_LEVEL) {

            throw new \Exception;
        }

        $pumpOil->update([
            'pump_level'  => $newLevel,

        ]);

    }

}
