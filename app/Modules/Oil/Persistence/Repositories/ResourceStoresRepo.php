<?php

namespace App\Modules\Oil\Persistence\Repositories;

use App\Modules\Oil\Actions\ResourceStore\OilStoreUpgradeCmd;
use App\Modules\Oil\Actions\ResourceStore\PetrolStoreUpgradeCmd;
use App\Modules\Oil\Actions\ResourceStore\WaterStoreUpgradeCmd;
use App\Modules\Oil\Persistence\Dao\ResourceStoresDao;

class ResourceStoresRepo
{
    const OIL_START_AMOUNT    = 50;
    const PETROL_START_AMOUNT = 20;
    const WATER_START_AMOUNT  = 6;
    
    /** @var ResourceStoresDao */
    private $resourceStoresDao;

    public function __construct(ResourceStoresDao $resourceStoresDao)
    {
        $this->resourceStoresDao = $resourceStoresDao;
    }

    public function createResourceStore($hero_id)
    {
        $this->resourceStoresDao->create(
            $hero_id,
            1,
            OilStoreUpgradeCmd::getOilStoreCapacityByLevel(1),
            self::OIL_START_AMOUNT,
            
            1,
            PetrolStoreUpgradeCmd::getPetrolStoreCapacityByLevel(1),
            self::PETROL_START_AMOUNT,
            
            1,
            WaterStoreUpgradeCmd::getWaterStoreCapacityByLevel(1),
            self::WATER_START_AMOUNT,
            
            1, 1
        );
        
    }
}
