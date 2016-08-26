<?php

namespace App\Modules\Drive\Commands\Raid;

use App\Models\Core\Hero;
use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use App\Repositories\Drive\RaidRepository;
use App\Repositories\HeroRepositoryObj;
use Finite\Exception\StateException;

class CompleteRaidCommand
{
    /** @var RaidRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
//        $this->heroRepo = $heroRepo;
    }

    public function completeRaid($raid_id)
    {
        $this->validateCommand($raid_id);
        
        
        $raidService = new ActiveRaidService();
     
        
        \DB::beginTransaction();
        try {

            
            $raidService->completeRaid($raid_id);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    /** @deprecated  */ // redo
    private function validateCommand($raid_id)
    {
        $raid = $this->raidRepo->findSimpleRaid($raid_id);
        
        if (null === $raid) {

            throw new StateException;
        }
    }
}
