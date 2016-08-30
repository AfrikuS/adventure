<?php

namespace App\Modules\Drive\Actions\Raid\Robbery;

use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberyRepo;
use Finite\Exception\StateException;

class StartRobberyCommand
{
    /** @var RobberyRepo */
    private $robberyRepo;

    public function __construct()
    {
        $this->robberyRepo = app('DriveRobberyRepo');
    }

    public function startRobbery($driver_id, $victim_id) // RaidEntity $raid
    {
//        $robbery = $this->robberyRepo->findRobbery($driver_id);
        
        $this->validateAction($driver_id);
        
        /** @var RobberyService $robberyService */
        $robberyService = app('RobberyService'); //new RobberyService();

        $raidService = new ActiveRaidService();
        
        \DB::beginTransaction();
        try {


            $raidService->startRobbery($driver_id);
            
            
            $robberyService->visitVictim($driver_id, $victim_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateAction($raid_id)
    {
        $raid = $this->robberyRepo->findRobbery($raid_id);

        if ($raid->robbery_status != null) {

            throw new StateException;
        }
    }
}
