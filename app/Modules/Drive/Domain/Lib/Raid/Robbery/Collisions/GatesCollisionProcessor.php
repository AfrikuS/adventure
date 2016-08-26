<?php

namespace App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions;

class GatesCollisionProcessor
{
    public $gatesData;
    public $vehicleData;

    public function process($gatesLevel, $vehicleMobility)
    {
        $vehiclePower = $vehicleMobility;
        $gatesBrone = 12; //$gatesLevel;

        $result = 'unSuccess';

        if ($vehiclePower >= $gatesBrone) {

            $result = 'success'; 
        }
        
        $collisionResult = new CollisionResult('gates', $result, $vehiclePower, $gatesBrone);
        
        return $collisionResult;
    }
}
