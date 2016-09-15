<?php

namespace App\Modules\Drive\Domain\Services\Raid;

use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;

class RobberyService
{
    const RAID_STATUS_SWITCH = 'switch_action';
    const RAID_STATUS_IN_ROBBERY = 'in_robbery';

    /** @var RobberiesRepo */
    private $robberyRepo;

    public function __construct()
    {
        $this->robberyRepo = app('DriveRobberyRepo');
    }

    public function visitVictim($raid_id, $victim_id)
    {
        /** @var Robbery $robbery */
        $robbery = $this->robberyRepo->findByRaid($raid_id);
        
        
        $robbery->victim_id = $victim_id;

        $robbery->status = Robbery::STATUS_GATES;
        
        
        $this->robberyRepo->updateRobberyData($robbery);
    }

//    /** @deprecated  */
//    public function completeRobbery(Robbery $robbery)
//    {
//        $this->robberyRepo->delete($robbery->id);
//    }

    public function handleSuccessCollision($collisionResult)
    {

    }

    public function handleFailCollision($collisionResult)
    {

    }

    public function abort(Robbery $robbery)
    {
        $robbery->abort();
        
        $this->robberyRepo->updateRobberyData($robbery);
    }

    public function initRobbery($raid_id, $vehicle_id)
    {
        $this->robberyRepo->create(
            $raid_id,
            $vehicle_id,
            Robbery::NO_ACTIVE
        );
    }

    public function completeRaid($raid_id)
    {
        $this->robberyRepo->delete($raid_id);
    }
}
