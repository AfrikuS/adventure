<?php

namespace App\Http\Middleware;

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

        $vehicleRepo = new VehicleRepository();
        $vehicle = $vehicleRepo->findSimpleVehicleByDriverId($user_id);

        if ($vehicle->state == 'broken') {

            return \Redirect::route('drive_raid_vehicle_broken_page');
        }

        return $next($request);
    }

}
