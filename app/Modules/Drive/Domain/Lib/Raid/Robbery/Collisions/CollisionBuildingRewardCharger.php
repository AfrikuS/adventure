<?php

namespace App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions;

class CollisionBuildingRewardCharger
{
    public static function collisionGatesReward(): int
    {
        return rand(500, 800);
    }
}
