<?php

namespace App\Modules\Drive\Domain\Services\Raid;

use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;

class RobberyService
{
    const RAID_STATUS_SWITCH = 'switch_action';
    const RAID_STATUS_IN_ROBBERY = 'in_robbery';

    const ROBBERY_STATUS_FENCE = 'fence';
    const ROBBERY_STATUS_GATES = 'gates';
    const ROBBERY_STATUS_COURTYARD = 'courtyard';
    const ROBBERY_STATUS_AMBAR = 'ambar';
    const ROBBERY_STATUS_WAREHOUSE = 'warehouse';
    const ROBBERY_STATUS_HOUSE = 'house';

    /** @var RobberyRepo */
    private $robberyRepo;

    public function __construct(RobberyRepo $robberyRepo)
    {
        $this->robberyRepo = $robberyRepo;
    }

    public function visitVictim($raid_id, $victim_id)
    {
        $robbery = $this->robberyRepo->findRobbery($raid_id);
        
        
        $robbery->victim_id = $victim_id;

        $robbery->robbery_status = self::ROBBERY_STATUS_GATES;
        
        
        $this->robberyRepo->updateRobberyData($robbery);
    }

    public function completeRobbery($robbery_id)
    {
        $this->robberyRepo->delete($robbery_id);
    }

    public function handleSuccessCollision($collisionResult)
    {

    }

    public function handleFailCollision($collisionResult)
    {

    }
}
