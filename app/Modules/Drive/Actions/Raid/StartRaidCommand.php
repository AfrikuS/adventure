<?php

namespace App\Modules\Drive\Actions\Raid;

use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;

class StartRaidCommand
{
    /** @var RaidRepo */
    private $raidRepo;
    
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function createRaid($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);
        
        $this->validateAction();
        
        $raidService = new ActiveRaidService();
        
        \DB::beginTransaction();
        try {


            $raidService->startRaid($vehicle);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

    private function validateAction()
    {
//        isRaidExist => to middleware
    }

}
