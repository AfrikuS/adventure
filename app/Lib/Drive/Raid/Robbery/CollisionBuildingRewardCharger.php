<?php

namespace App\Lib\Drive\Raid\Robbery;

class CollisionBuildingRewardCharger
{
    public static function collisionGatesReward(): int
    {
        return rand(500, 800);
    }
}
