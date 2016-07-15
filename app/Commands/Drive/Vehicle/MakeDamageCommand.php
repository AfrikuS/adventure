<?php

namespace App\Commands\Drive\Vehicle;

use App\Entities\Drive\VehicleEntity;
use App\Models\Drive\Vehicle;

class MakeDamageCommand
{
    public function makeDamage(VehicleEntity $vehicle, $damageAmount)
    {
        $vehicle->makeDamage($damageAmount);
    }
}
