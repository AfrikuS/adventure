<?php

namespace App\Modules\Drive\Actions\Raid;

use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Exceptions\Controllers\SearchSuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;
use Finite\Exception\StateException;

class SearchVictimCommand
{
    /** @var RaidsRepo */
    private $raidRepo;

    /** @var RobberiesRepo */
    private $robberiesRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
        $this->robberiesRepo = app('DriveRobberyRepo');
    }


    public function searchVictim($driver_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findByDriver($driver_id);

        $this->validateCommand($raid);
        
        

        $fond_victim_id = $driver_id;
        
        $raid->fondVictim();

        
        
        $this->raidRepo->updateRaidData($raid);


        /** @var Robbery $robbery */
        $robbery = $this->robberiesRepo->findByRaid($raid->id);
        $robbery->fondVictim($fond_victim_id);
        $this->robberiesRepo->updateVictim($robbery);
        
        
    }

    private function validateCommand(Raid $raid)
    {
        if ($raid->status !== Raid::STATUS_FREE &&
            $raid->status !== Raid::STATUS_SEARCH_VICTIM) {

            throw new StateException;
        }
    }
}
