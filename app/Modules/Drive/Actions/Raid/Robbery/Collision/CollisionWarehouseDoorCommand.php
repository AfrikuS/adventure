<?php

namespace App\Modules\Drive\Actions\Raid\Robbery\Collision;

use App\Modules\Drive\Domain\Entities\Garage\RepairVehicle;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions\GatesCollisionProcessor;
use App\Modules\Drive\Exceptions\Controllers\CollisionSuccess_Exception;
use App\Modules\Drive\Exceptions\Controllers\CollisionUnsuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;
use App\Modules\Hero\Persistence\Repositories\BuildingsRepo;
use Finite\Exception\StateException;

class CollisionWarehouseDoorCommand
{
    /** @var RobberiesRepo */
    private $robberyRepo;

    /** @var BuildingsRepo */
    private $buildingsRepo;

    public function __construct()
    {
        $this->robberyRepo = app('DriveRobberyRepo');
        $this->buildingsRepo = app('BuildingsRepo');
    }

    public function warehouseDoorCollision($driver_id)
    {
        $this->validateCommand($driver_id);

        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findByRaid($driver_id);
        $victim_id = $robbery->victim_id;
        $buildings = $this->buildingsRepo->getByHero($victim_id);

        /** @var RepairVehicle $robberyVehicle */
        $robberyVehicle = app('DriveVehiclesRepo')->find($robbery->vehicle_id);

        $processor = new GatesCollisionProcessor();

        $collisionResult = $processor->process(
            $buildings->warehauseLevel,
            $robberyVehicle->mobility
        );

        \DB::beginTransaction();
        try {

//            $robberyVehicle->makeDamage($collisionResult->buildingDamage);
//            $buildings->makeFenceDamage($collisionResult->vehicleDamage);
            $robbery->driveInWarehouse();

//            $this->buildingsRepo->updateBuildings($buildings);
            $this->robberyRepo->updateRobberyData($robbery);

        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    private function validateCommand($robbery_id)
    {
        $robbery = $this->robberyRepo->findByRaid($robbery_id);

        if ($robbery->status != Robbery::STATUS_COURTYARD) {

            throw new StateException;
        }
    }
}