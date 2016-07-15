<?php

namespace App\Commands\Drive\Raid\Robbery\Collision;

use App\Entities\Drive\RaidEntity;
use App\Entities\Drive\RaidVehicle;
use App\Entities\Drive\RobberyEntity;
use App\Lib\Drive\Raid\Robbery\CollisionResultDto;
use App\Models\Drive\Vehicle;

class CollisionGatesCommand
{
    /** @var CollisionResultDto */
    private $collisionResult;

    public function __construct(CollisionResultDto $collisionResult)
    {
        $this->collisionResult = $collisionResult;
    }

    public function handleCollision(RaidEntity $raid,
                                    RobberyEntity $robbery,
                                    RaidVehicle $vehicle)
    {
        // update damage for vehicle


        \DB::beginTransaction();
        try {


//            $vehicle = $collisionResult->vehicle;
            $vehicleDamage = $this->collisionResult->vehicleDamage;

            /** @var RaidVehicle $vehicle */
            $vehicle->makeDamage($vehicleDamage);


            /** @var RaidEntity $raid */
            $raid->addReward($this->collisionResult->reward);

            $robbery->driveInGates();


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
