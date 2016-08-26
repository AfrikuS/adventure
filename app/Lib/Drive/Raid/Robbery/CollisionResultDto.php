<?php

namespace App\Lib\Drive\Raid\Robbery;

class CollisionResultDto
{
    public $status;
    public $building;
    public $buildingDamage;
    public $vehicleDamage;
    public $reward;
    
    public $vehiclePower;
    public $buildingDuracity;

    public function __construct($status, $vehicleDamage, $reward, $building, $buildingDamage,
                                $vehiclePower, $buildingDuracity)
    {
        $this->status = $status;
        $this->vehicleDamage = $vehicleDamage;
        $this->reward = $reward;
        $this->building = $building;
        $this->buildingDamage = $buildingDamage;
        
        $this->vehiclePower = $vehiclePower;
        $this->buildingDuracity = $buildingDuracity;
    }

//    public static function create($status, $vehicleDamage, $reward, $building, $buildingDamage)
//    {
//        return new CollisionResultDto($status, $vehicleDamage, $reward, $building, $buildingDamage);
//    }
}
