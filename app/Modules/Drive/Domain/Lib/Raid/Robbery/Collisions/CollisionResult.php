<?php

namespace App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions;

class CollisionResult
{
    public $building;
    
    public $result;
    public $vehicleDamage;
    public $buildingDamage;

    public function __construct($building, $result, $vehicleDamage, $buildingDamage)
    {
        $this->building = $building;
        $this->result = $result;
        $this->vehiclePower = $vehicleDamage;
        $this->buildingDuracity = $buildingDamage;
        $this->reward = 'REWARD';
    }

}
