<?php

namespace App\Commands\Hero\ResourceStore;

use App\Exceptions\ResourceStoreCapacityLevelErrorException;
use App\Repositories\Core\ResourceStore\WaterStoreRepo;

class WaterStoreUpgradeCmd
{
    const MAX_WATER_CAPACITY_LEVEL    = 7;

    const WATER_CAPACITY_MAP =
        [
            1 => 10,
            2 => 15,
            3 => 20,
            4 => 27,
            5 => 35,
            6 => 42,
            7 => 50,
        ];

    /** @var  WaterStoreRepo */
    private $waterStoreRepo;

    public static function getWaterStoreCapacityByLevel($level)
    {
        return self::WATER_CAPACITY_MAP[$level];
    }

    public function __construct(WaterStoreRepo $waterStoreRepo)
    {
        $this->waterStoreRepo = $waterStoreRepo;
    }

    public function upgrade($hero_id)
    {
        $waterStore = $this->waterStoreRepo->findWaterStoreByHeroId($hero_id);


        $newLevel = $waterStore->water_capacity_level + 1;

        
        if ($newLevel > self::MAX_WATER_CAPACITY_LEVEL) {

            throw new ResourceStoreCapacityLevelErrorException;
        }

        $capacityAmount = static::getWaterStoreCapacityByLevel($newLevel);

        $waterStore->update([
            'water_capacity_level'  => $newLevel,
            'water_capacity_amount' => $capacityAmount,

        ]);

    }
}
