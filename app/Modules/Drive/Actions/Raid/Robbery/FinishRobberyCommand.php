<?php

namespace App\Modules\Drive\Actions\Raid\Robbery;

use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Persistence\Repositories\Raid\RobberiesRepo;

class FinishRobberyCommand
{
    /** @var RobberiesRepo */
    private $robberiesRepo;

    public function __construct()
    {
        $this->robberiesRepo = app('DriveRobberyRepo');
    }

    public function finishRobbery($robbery_id)
    {
        $robbery = $this->robberiesRepo->findByRaid($robbery_id);
        $this->validateCommand($robbery);


        $raidService = new ActiveRaidService();
        
//        $raid = $this->robberiesRepo->findRaidById($robbery_id);

        /** @var RobberyService $robberyService */
        $robberyService = new RobberyService;


        \DB::beginTransaction();
        try {


            $raidService->completeRobbery($robbery_id);

            $robberyService->abort($robbery);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateCommand(Robbery $robbery)
    {
//        $raid = $this->robberiesRepo->findRaidById($robbery_id);
    }
}
