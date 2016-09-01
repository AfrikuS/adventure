<?php

namespace App\Modules\Oil\Actions\ResourceStore;

use App\Exceptions\ResourceStoreCapacityLevelErrorException;
use App\Repositories\Core\ResourceStore\OilStoreRepo;

class OilStoreUpgradeCmd
{
    const MAX_OIL_CAPACITY_LEVEL    = 7;

    const OIL_CAPACITY_MAP =
        [
            1 => 100,
            2 => 150,
            3 => 200,
            4 => 270,
            5 => 350,
            6 => 420,
            7 => 500,
        ];

    /** @var  OilStoreRepo */
    private $oilStoreRepo;

    public static function getOilStoreCapacityByLevel($level)
    {
        return self::OIL_CAPACITY_MAP[$level];
    }

    public function __construct(OilStoreRepo $oilStoreRepo)
    {
        $this->oilStoreRepo = $oilStoreRepo;
    }

    public function upgrade($hero_id)
    {
        $oilStore = $this->oilStoreRepo->findOilStoreByHeroId($hero_id);


        $newLevel = $oilStore->oil_capacity_level + 1;

        
        if ($newLevel > self::MAX_OIL_CAPACITY_LEVEL) {

            throw new ResourceStoreCapacityLevelErrorException;
        }

        $capacityAmount = static::getOilStoreCapacityByLevel($newLevel);

        $oilStore->update([
            'oil_capacity_level'  => $newLevel,
            'oil_capacity_amount' => $capacityAmount,

        ]);

    }
}
