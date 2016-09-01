<?php

namespace App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions;

use App\Entities\Drive\RaidVehicle;
use App\Lib\Drive\DamageCalculator;
use App\Models\Core\Buildings;
use App\Models\Drive\Vehicle;

class CollisionProcessor
{
    private $vehicle;

    /** @var  Buildings */
    private $buildings;

    /** @var DamageCalculator */
    private $damageCalculator;

    public function __construct(RaidVehicle $vehicle, Buildings $buildings)
    {
        $this->vehicle = $vehicle;
        $this->buildings = $buildings;
        $this->damageCalculator = new DamageCalculator();
    }

    public function processCollision($buildingCode): CollisionResultDto
    {
        srand();// init random

        $buildingLevel = $this->getBuildingLevel($this->buildings, $buildingCode);

        $vehiclePower = $this->calculateVehiclePower();
        $buildingDuracity = $this->calculateBuildingDuracity($buildingLevel);

        $reward = 0;
        $status = 'failed';
        
        if ($vehiclePower > $buildingDuracity) {
            
            $reward = $this->calculateCollisionReward($buildingCode, $buildingDuracity);

            $status = 'success';
        }

        
        $vehicleDamage = $this->damageCalculator->getDamage($buildingDuracity, $vehiclePower);
        $buildingDamage = $this->damageCalculator->getDamage($buildingDuracity, $vehiclePower);
        
        
        
        $result = new CollisionResultDto($status, $vehicleDamage, $reward, 
                        $buildingCode, $buildingDamage, $vehiclePower, $buildingDuracity);

        return $result;
    }
    
    private function calculateVehiclePower()
    {
        $velocity = $this->vehicle->acceleration;
        $mass = 19; // $this->vehicle->mass;

        $charge = $velocity * $mass;
        $arrowhead = (rand(900, 1100) / 1000) ;

        $resultVehiclePower = $charge * $arrowhead;

        return $resultVehiclePower;
    }

    private function calculateBuildingDuracity($buildingLevel)
    {
        $victimFortune = (rand(1200, 1500) / 1000);

//        $buidlingField = $buildingCode.'_level';


//        $resultBuildingPower = $this->buildings->$buidlingField * 12 * $victimFortune; // armor
        $resultBuildingPower = $buildingLevel * 12 * $victimFortune; // armor

        return $resultBuildingPower;
    }

    private function calculateCollisionReward($buildingCode, $buildingDuracity)
    {
        return CollisionBuildingRewardCharger::collisionGatesReward();
    }

    private function getBuildingLevel($buildings, $buildingCode)
    {
        switch ($buildingCode) 
        {
            case 'gates':
                return $buildings->gates_level;

            case 'fence':
                return $buildings->fence_level;

            case 'house':
                return $buildings->door_house_level;

            case 'ambar':
                return $buildings->door_ambar_level;

            case 'warehouse':
                return $buildings->door_resource_warehause_level;

            default:
                throw new \Exception;
        }
    }
}
