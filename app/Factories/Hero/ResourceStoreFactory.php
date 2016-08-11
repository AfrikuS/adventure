<?php

namespace App\Factories\Hero;

use App\Commands\Hero\ResourceStore\OilStoreUpgradeCmd;
use App\Commands\Hero\ResourceStore\PetrolStoreUpgradeCmd;
use App\Commands\Hero\ResourceStore\WaterStoreUpgradeCmd;
use App\Models\Core\ResourceStore;

class ResourceStoreFactory
{
    const OIL_START_AMOUNT    = 50;
    const PETROL_START_AMOUNT = 20;
    const WATER_START_AMOUNT  = 6;
    
    public function createResourceStore($hero_id)
    {
        return ResourceStore::create([
            
            'hero_id' => $hero_id,
            
            'oil_capacity_level' => 1,
            'oil_capacity_amount' => OilStoreUpgradeCmd::getOilStoreCapacityByLevel(1),
            'oil_amount' => self::OIL_START_AMOUNT,

            'petrol_capacity_level' => 1,
            'petrol_capacity_amount' => PetrolStoreUpgradeCmd::getPetrolStoreCapacityByLevel(1),
            'petrol_amount' => self::PETROL_START_AMOUNT,

            'water_capacity_level' => 1,
            'water_capacity_amount' => WaterStoreUpgradeCmd::getWaterStoreCapacityByLevel(1), // review
            'water_amount' => self::WATER_START_AMOUNT,

        ]);
    }

}
