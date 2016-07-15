<?php

namespace App\Lib\Drive\Raid\Robbery;

use App\Entities\Drive\RaidVehicle;
use App\Lib\Drive\DamageCalculator;
use App\Models\Core\Buildings;
use App\Models\Drive\Vehicle;

class CollisionProcessor
{
    private $vehicle;
//    private $buildings;
    /** @var DamageCalculator */
    private $damageCalculator;

    public function __construct(RaidVehicle $vehicle)
    {
//        $this->buildings = $buildings;
        $this->vehicle = $vehicle;
        $this->damageCalculator = new DamageCalculator();
    }

    public function processCollision($buildingCode): CollisionResultDto
    {
        srand();// init random

        $vehiclePower = $this->calculateVehiclePower();
        $buildingDuracity = $this->calculateBuildingDuracity($buildingCode);

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

    private function calculateBuildingDuracity($buildingCode)
    {
        $victimFortune = (rand(1000, 1500) / 1000);

//        $buidlingField = $buildingCode.'_level';


//        $resultBuildingPower = $this->buildings->$buidlingField * 12 * $victimFortune; // armor
        $resultBuildingPower = 39 * 12 * $victimFortune; // armor

        return $resultBuildingPower;
    }

    private function calculateCollisionReward($buildingCode, $buildingDuracity)
    {
        return CollisionBuildingRewardCharger::collisionGatesReward();
    }
}
