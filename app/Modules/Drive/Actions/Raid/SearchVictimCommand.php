<?php

namespace App\Modules\Drive\Actions\Raid;

use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Exceptions\Controllers\SearchSuccess_Exception;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;
use Finite\Exception\StateException;

class SearchVictimCommand
{
    /** @var RaidsRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
    }


    public function searchVictim($driver_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findByDriver($driver_id);

        $this->validateCommand($raid);
        
        

        $fond_victim_id = $driver_id;
        
        $raid->fondVictim($fond_victim_id);

        
        
        $this->raidRepo->updateRaidData($raid);
        
        
        throw new SearchSuccess_Exception($raid);
    }

    private function validateCommand(Raid $raid)
    {
        if ($raid->status !== Raid::STATUS_FREE &&
            $raid->status !== Raid::STATUS_SEARCH_VICTIM) {

            throw new StateException;
        }
    }
}
