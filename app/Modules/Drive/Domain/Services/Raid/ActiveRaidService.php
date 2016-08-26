<?php

namespace App\Modules\Drive\Domain\Services\Raid;

use App\Handlers\Commands\Hero\IncrementGold;
use App\Modules\Drive\Domain\Commands\Raid\DeleteRaid;
use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use Illuminate\Support\Facades\Bus;

class ActiveRaidService
{
    /** @var RaidRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
    }

    public function completeRaid($raid_id)
    {
        $raid = $this->raidRepo->findSimpleRaid($raid_id);
        
        $driver_id = $raid->id;

        

        $getReward = new IncrementGold($driver_id, $raid->reward);
        
        Bus::dispatch($getReward);

        
        $deleteRaid = new DeleteRaid($raid->id);

        Bus::dispatch($deleteRaid);
    }

    public function startRobbery($raid_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findSimpleRaid($raid_id);
        
        $raid->setStatusInRobbery();
        
        $this->raidRepo->updateRaidData($raid);
    }

    public function completeRobbery($raid_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findSimpleRaid($raid_id);

        
        
        
        $raid->setStatusFree();

        $this->raidRepo->updateRaidData($raid);
    }
}
