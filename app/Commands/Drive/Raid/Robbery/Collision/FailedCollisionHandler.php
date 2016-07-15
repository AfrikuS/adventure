<?php

namespace App\Commands\Drive\Raid\Robbery\Collision;

use App\Entities\Drive\RaidVehicle;
use App\Lib\Drive\Raid\Robbery\CollisionResultDto;

class FailedCollisionHandler
{
    /** @var CollisionResultDto */
    private $collisionResult;

    public function __construct(CollisionResultDto $collisionResult)
    {
        $this->collisionResult = $collisionResult;
    }

    public function handle(RaidVehicle $vehicle)
    {



        $vehicle->makeDamage($this->collisionResult->vehicleDamage);

        
        
    }
}
