<?php

namespace App\Modules\Drive\Commands\Raid\Robbery\Collision;

use App\Modules\Drive\Domain\Entities\Garage\RepairVehicle;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions\GatesCollisionProcessor;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Exceptions\Controllers\CollisionSuccess_Exception;
use App\Modules\Drive\Exceptions\Controllers\CollisionUnsuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;
use App\Modules\Hero\Persistence\Repositories\BuildingsRepo;
use Finite\Exception\StateException;

class CollisionFenceCommand
{
    /** @var RobberyRepo */
    private $robberyRepo;

    /** @var BuildingsRepo */
    private $buildingsRepo;

    public function __construct()
    {
        $this->robberyRepo   = app('DriveRobberyRepo');
        $this->buildingsRepo = app('BuildingsRepo');
    }

    public function driveInFence($driver_id)
    {
        $this->validateCommand($driver_id);

        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findRobbery($driver_id);
        $victim_id = $robbery->victim_id;
        $buildings = $this->buildingsRepo->getByHero($victim_id);


        /** @var RepairVehicle $robberyVehicle */
        $robberyVehicle = app('DriveVehiclesRepo')->findRobberyVehicle($robbery->vehicle_id);

        $processor = new GatesCollisionProcessor();

        $collisionResult = $processor->process(
            $buildings->fenceLevel,
            $robberyVehicle->mobility
        );



        \DB::beginTransaction();
        try {


//            $robberyVehicle->makeDamage($collisionResult->buildingDamage);
//            $buildings->makeFenceDamage($collisionResult->vehicleDamage);
            $robbery->driveInFence();

//            $this->buildingsRepo->updateBuildings($buildings);
            $this->robberyRepo->updateRobberyData($robbery);

        }
        catch(\Exception $e) {

            \DB::rollBack();
            throw $e;
        }
        \DB::commit();




        if ($collisionResult->result == 'success') {

//            $raid->addReward($this->collisionResult->reward);

            throw new CollisionSuccess_Exception($collisionResult);
        }

        else {

            throw new CollisionUnsuccess_Exception($collisionResult, $robberyVehicle);
        }
    }
        
    private function validateCommand($robbery_id)
    {
        $robbery = $this->robberyRepo->findRobbery($robbery_id);

        if ($robbery->robbery_status != RobberyService::ROBBERY_STATUS_FENCE) {

            throw new StateException;
        }
    }
}