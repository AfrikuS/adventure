<?php

namespace App\Modules\Drive\Domain\Services\Raid\Robbery;

use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions\GatesCollisionProcessor;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;
use App\Modules\Hero\Persistence\Repositories\BuildingsRepo;

class CollisionBuildingService
{
    /** @var RobberyRepo */
    private $robberyRepo;

    /** @var BuildingsRepo */
    private $buildingsRepo;
    
    public function __construct()
    {
        $this->robberyRepo = app('DriveRobberyRepo');
        $this->buildingsRepo = app('BuildingsRepo');
    }


    public function handleGatesCollision($driver_id)
    {
        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findRobbery($driver_id);

        $buildings = $this->buildingsRepo->getByHero($robbery->victim_id);


        /** @var RobberyVehicle $robberyVehicle */
        $robberyVehicle = app('DriveVehiclesRepo')->findRobberyVehicle($robbery->vehicle_id);

        $processor = new GatesCollisionProcessor();

        $collisionResult = $processor->process(
            $buildings->gatesLevel,
            $robberyVehicle->mobility
        );

        return $collisionResult;
    }
}
