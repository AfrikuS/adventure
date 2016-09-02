<?php

namespace App\Repositories\Core\ResourceStore;

use App\Commands\Hero\ResourceStore\PetrolStoreUpgradeCmd;
use App\Models\Core\ResourceStore;
use App\ViewData\Hero\ResourceStore\PetrolStore;

class PetrolStoreRepo
{

    public function findPetrolStoreByHeroId($hero_id)
    {
        $petrolStoreModel = $this->findPetrolStoreModel($hero_id);

        return $petrolStoreModel;
    }


    public function getPetrolStoreDto($hero_id)
    {
        $petrolStoreModel = $this->findPetrolStoreModel($hero_id);

        $petrolStoreDto = new PetrolStore
                            (
                                $petrolStoreModel->petrol_capacity_level,
                                $petrolStoreModel->petrol_capacity_amount,
                                $petrolStoreModel->petrol_amount
                            );

        return $petrolStoreDto;
    }

    public function getPetrolStoreNextDto($level)
    {
        $nextLevel = $level + 1;

        if ($nextLevel > PetrolStoreUpgradeCmd::MAX_PETROL_CAPACITY_LEVEL) {
            return null;
        }

        $capacity = PetrolStoreUpgradeCmd::getPetrolStoreCapacityByLevel($nextLevel);

        return new PetrolStore(
            $nextLevel,
            $capacity,
            0
        );
    }

    private function findPetrolStoreModel($hero_id)
    {
        $petrolModel = ResourceStore::
                select('hero_id', 'petrol_capacity_level', 'petrol_capacity_amount', 'petrol_amount')
                ->find($hero_id);

        return $petrolModel;
    }

}
