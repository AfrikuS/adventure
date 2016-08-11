<?php

namespace App\Repositories\Core\ResourceStore;

use App\Commands\Hero\ResourceStore\WaterStoreUpgradeCmd;
use App\Factories\Hero\ResourceStoreFactory;
use App\Models\Core\ResourceStore;
use App\ViewData\Hero\ResourceStore\WaterStoreDto;

class WaterStoreRepo
{
    public function findWaterStoreByHeroId($hero_id)
    {
        $waterStoreModel = $this->findWaterStoreModel($hero_id);

        return $waterStoreModel;
    }

    private function findWaterStoreModel($hero_id)
    {
        $model = ResourceStore::
                    select('hero_id', 'water_capacity_level', 'water_capacity_amount', 'water_amount')
                    ->find($hero_id);

        // todo init data command
        if (null == $model) {
            $factory = new ResourceStoreFactory();
            
            $model = $factory->createResourceStore($hero_id);
        }

        return $model;
    }

    public function getWaterStoreDto($hero_id)
    {
        $waterStoreModel = $this->findWaterStoreModel($hero_id);

        $waterStoreDto = new WaterStoreDto
                            (
                                $waterStoreModel->water_capacity_level,
                                $waterStoreModel->water_capacity_amount,
                                $waterStoreModel->water_amount
                            );

        return $waterStoreDto;
    }

    public function getWaterStoreNextDto($level)
    {
        $nextLevel = $level + 1;

        if ($nextLevel > WaterStoreUpgradeCmd::MAX_WATER_CAPACITY_LEVEL) {
            return null;
        }

        $capacity = WaterStoreUpgradeCmd::getWaterStoreCapacityByLevel($nextLevel);

        return new WaterStoreDto(
            $nextLevel,
            $capacity,
            0
        );
    }


}
