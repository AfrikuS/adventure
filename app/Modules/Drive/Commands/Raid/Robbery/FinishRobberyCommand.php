<?php

namespace App\Modules\Drive\Commands\Raid\Robbery;

use App\Entities\Drive\RobberyEntity;
use App\Models\Drive\Robbery;
use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Domain\Services\Raid\RobberyService;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use App\Repositories\Drive\RaidRepository;

class FinishRobberyCommand
{
    /** @var RaidRepo */
    private $raidRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
    }

    public function finishRobbery($robbery_id)
    {

        $this->validateCommand($robbery_id);


        $raidService = new ActiveRaidService();
        
//        $raid = $this->raidRepo->findRaidById($robbery_id);

        /** @var RobberyService $robberyService */
        $robberyService = app('RobberyService');


        \DB::beginTransaction();
        try {


            $raidService->completeRobbery($robbery_id);

            $robberyService->completeRobbery($robbery_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateCommand($robbery_id)
    {
//        $raid = $this->raidRepo->findRaidById($robbery_id);
    }
}
