<?php

namespace App\Modules\Drive\Actions\Raid\Robbery\Collision;

use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Entities\Raid\RobberyVehicle;
use App\Modules\Drive\Domain\Services\Raid\Robbery\CollisionBuildingService;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Exceptions\Controllers\CollisionSuccess_Exception;
use App\Modules\Drive\Exceptions\Controllers\CollisionUnsuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;
use Finite\Exception\StateException;

class CollisionGatesCommand
{
    /** @var RobberyRepo */
    private $robberyRepo;

    public function __construct()
    {
        $this->robberyRepo   = app('DriveRobberyRepo');
    }

    public function driveInGates($driver_id)
    {
        $this->validateCommand($driver_id);

        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findRobbery($driver_id);

        /** @var RobberyVehicle $robberyVehicle */
        $robberyVehicle = app('DriveVehiclesRepo')->findRobberyVehicle($robbery->vehicle_id);

        
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




        if ($collisionResult->result == 'success') {

            throw new CollisionSuccess_Exception($collisionResult);
        }

        else {

            throw new CollisionUnsuccess_Exception($collisionResult, $robberyVehicle);
        }
    }

    private function validateCommand($robbery_id)
    {
        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findRobbery($robbery_id);

        if ($robbery->robbery_status != RobberyService::ROBBERY_STATUS_GATES) {

            throw new StateException;
        }

    }
}
