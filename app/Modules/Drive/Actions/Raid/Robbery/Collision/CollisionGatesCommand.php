<?php

namespace App\Modules\Drive\Actions\Raid\Robbery\Collision;

use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Entities\Raid\RobberyVehicle;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Domain\Services\Raid\Robbery\CollisionBuildingService;
use App\Modules\Drive\Exceptions\Controllers\CollisionSuccess_Exception;
use App\Modules\Drive\Exceptions\Controllers\CollisionUnsuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Finite\Exception\StateException;

class CollisionGatesCommand
{
    /** @var RobberiesRepo */
    private $robberyRepo;

    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct()
    {
        $this->robberyRepo   = app('DriveRobberyRepo');

        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function driveInGates($driver_id)
    {
        $this->validateCommand($driver_id);

        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findByRaid($driver_id);

        /** @var Vehicle $robberyVehicle */
        $robberyVehicle = $this->vehiclesRepo->find($robbery->vehicle_id);

        
        $collisionService = new CollisionBuildingService();

        $collisionResult = $collisionService->handleGatesCollision($driver_id);


        \DB::beginTransaction();
        try {


            $robbery->driveInGates();

            $this->robberyRepo->updateRobberyData($robbery);

        }
        catch(\Exception $e) {

            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    private function validateCommand($robbery_id)
    {
        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findByRaid($robbery_id);

        if ($robbery->status != Robbery::STATUS_GATES) {

            throw new StateException;
        }

    }
}
