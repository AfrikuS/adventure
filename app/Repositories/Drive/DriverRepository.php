<?php

namespace App\Repositories\Drive;

use App\Models\Drive\Driver;
use App\Models\Drive\Vehicle;

class DriverRepository
{

    public function findById($user_id)
    {
        return Driver::find($user_id);
    }

    public function createDriver($user_id)
    {
        return Driver::create([
            'id' => $user_id,
            'status' => 'free',
            'active_vehicle_id' => null,
        ]);
    }

    public function createFirstVehicle($driver_id, $title = 'беглый Джек-сон')
    {
        return Vehicle::create([
            'driver_id'      => $driver_id,
            'acceleration'   => 30,
            'stability'      => 40,
            'mobility'       => 50,
            'fuel_level'     => 650,
            'damage_percent' => 0,
            'state'          => 'normal',
        ]);
    }

}
