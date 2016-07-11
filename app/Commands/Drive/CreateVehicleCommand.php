<?php

namespace App\Commands\Drive;

use App\Models\Drive\Vehicle;

class CreateVehicleCommand
{

    public function createVehicle($driver_id): Vehicle
    {
        return Vehicle::create([
            'driver_id'    => $driver_id,
            'acceleration' => 30,
            'stability'    => 40,
            'mobility'     => 50,
        ]);
    }
}
