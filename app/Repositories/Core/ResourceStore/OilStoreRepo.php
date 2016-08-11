<?php

namespace App\Repositories\Core\ResourceStore;

use App\Commands\Hero\ResourceStore\OilStoreUpgradeCmd;
use App\Factories\Hero\ResourceStoreFactory;
use App\Models\Core\ResourceStore;
use App\ViewData\Hero\ResourceStore\OilStoreDto;

class OilStoreRepo
{
    public function findOilStoreByHeroId($hero_id)
    {
        $oilStoreModel = $this->findOilStoreModel($hero_id);

        return $oilStoreModel;
    }

    private function findOilStoreModel($hero_id)
    {
        $model = ResourceStore::
                    select('hero_id', 'oil_capacity_level', 'oil_capacity_amount', 'oil_amount')
                    ->find($hero_id);

        // todo init data command
        if (null == $model) {
            $factory = new ResourceStoreFactory();
            
            $model = $factory->createResourceStore($hero_id);
        }

        return $model;
    }

    public function getOilStoreDto($hero_id)
    {
        $oilStoreModel = $this->findOilStoreModel($hero_id);

        $oilStoreDto = new OilStoreDto
                            (
                                $oilStoreModel->oil_capacity_level,
                                $oilStoreModel->oil_capacity_amount,
                                $oilStoreModel->oil_amount
                            );

        return $oilStoreDto;
    }

    public function getOilStoreNextDto($level)
    {
        $nextLevel = $level + 1;

        if ($nextLevel > OilStoreUpgradeCmd::MAX_OIL_CAPACITY_LEVEL) {
            return null;
        }

        $capacity = OilStoreUpgradeCmd::getOilStoreCapacityByLevel($nextLevel);

        return new OilStoreDto(
            $nextLevel,
            $capacity,
            0
        );
    }


}
