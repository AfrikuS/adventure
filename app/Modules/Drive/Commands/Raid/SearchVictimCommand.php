<?php

namespace App\Modules\Drive\Commands\Raid;

use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Exceptions\Controllers\SearchSuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use Finite\Exception\StateException;

class SearchVictimCommand
{
    /** @var RaidRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
    }


    public function searchVictim($driver_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findSimpleRaid($driver_id);

        $this->validateCommand($raid);
        
        

        $fond_victim_id = $driver_id;
        
        $raid->fondVictim($fond_victim_id);

        
        
        $this->raidRepo->updateRaidData($raid);
        
        
        throw new SearchSuccess_Exception($raid);
    }

    private function validateCommand(Raid $raid)
    {
        if ($raid->status !== Raid::RAID_STATUS_FREE &&
            $raid->status !== Raid::RAID_STATUS_SEARCH_VICTIM) {

            throw new StateException;
        }
    }
}
