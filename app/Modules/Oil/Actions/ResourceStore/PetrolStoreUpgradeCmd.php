<?php

namespace App\Modules\Oil\Actions\ResourceStore;

use App\Exceptions\ResourceStoreCapacityLevelErrorException;
use App\Repositories\Core\ResourceStore\PetrolStoreRepo;

class PetrolStoreUpgradeCmd
{
    const MAX_PETROL_CAPACITY_LEVEL = 7;
    const PETROL_CAPACITY_MAP =
        [
            1 => 50,
            2 => 75,
            3 => 100,
            4 => 150,
            5 => 200,
            6 => 250,
            7 => 300,
        ];

    /** @var  PetrolStoreRepo */
    private $petrolStoreRepo;


    public static function getPetrolStoreCapacityByLevel($level)
    {
        return self::PETROL_CAPACITY_MAP[$level];
    }
    

    public function __construct(PetrolStoreRepo $petrolStore)
    {
        $this->petrolStoreRepo = $petrolStore;
    }


    public function upgradeLevel($hero_id)
    {
        $petrolStore = $this->petrolStoreRepo->findPetrolStoreByHeroId($hero_id);


        $newLevel = $petrolStore->petrol_capacity_level + 1;


        if ($newLevel > self::MAX_PETROL_CAPACITY_LEVEL) {

            throw new ResourceStoreCapacityLevelErrorException;
        }

        $capacityAmount = static::getPetrolStoreCapacityByLevel($newLevel);

        $petrolStore->update([
            'petrol_capacity_level'  => $newLevel,
            'petrol_capacity_amount' => $capacityAmount,

        ]);

    }

}
