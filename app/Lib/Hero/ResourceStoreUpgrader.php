<?php

namespace App\Lib\Hero;

use App\Entities\Hero\PetrolStoreEntity;
use App\Exceptions\ResourceStoreCapacityLevelErrorException;

class ResourceStoreUpgrader
{
    public static function getPetrolStoreCapacityByLevel($level)
    {
        if ($level < 1 || $level > self::MAX_PETROL_CAPACITY_LEVEL) {

            throw new ResourceStoreCapacityLevelErrorException;
        }

        return self::PETROL_CAPACITY_MAP[$level];
    }


}
