<?php

namespace App\Http\Middleware;

use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use App\Repositories\Drive\RaidRepository;
use App\Repositories\Drive\VehicleRepository;
use Closure;
use Illuminate\Support\Facades\Session;

class VehicleBrokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $user_id = \Auth::id();


//        $raidRepo = new RaidRepository();
//        $raid = $raidRepo->findRaidById($user_id);



//        $vehicleRepo = new VehicleRepository();
        /** @var VehiclesRepo $vehicleRepo */
        $vehicleRepo = app('DriveVehiclesRepo');
        $vehicle = $vehicleRepo->findActiveByDriver($user_id);

        if ($vehicle->isBroken()) {

            return \Redirect::route('drive_raid_vehicle_broken_page');
        }

        return $next($request);
    }

}
