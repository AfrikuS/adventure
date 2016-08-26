<?php

namespace App\Repositories\Drive;

use App\Entities\Drive\RaidVehicle;
use App\Models\Drive\Vehicle;

class VehicleRepository
{
    public function findWithDetailsByDriverId($driver_id)
    {
        return Vehicle::
            where('driver_id', $driver_id)
            ->with('details')
            ->first();
    }

    public function findSimpleVehicleByDriverId($driver_id): RaidVehicle
    {
        $vehicle = Vehicle::where('driver_id', $driver_id)->with('details')->first();
        
        return new RaidVehicle($vehicle);
    }

    /** @deprecated  */
    public function findRaidVehicleById($id)
    {
        $vehicle = Vehicle::find($id);
        
        return new RaidVehicle($vehicle);
    }
}
