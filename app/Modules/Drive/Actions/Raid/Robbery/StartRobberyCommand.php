<?php

namespace App\Modules\Drive\Actions\Raid\Robbery;

use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;
use Finite\Exception\StateException;

class StartRobberyCommand
{
    /** @var RobberiesRepo */
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
        $robberyService = new RobberyService();

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
        $robbery = $this->robberyRepo->findByRaid($raid_id);

        if ($robbery->status != Robbery::NO_ACTIVE) {

            throw new StateException('Вы уже участвуете в разбое');
        }
    }
}
