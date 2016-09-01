<?php

namespace App\Modules\Drive\Actions\Raid;

use App\Modules\Drive\Domain\Services\Raid\ActiveRaidService;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;
use App\Modules\Drive\Persistence\Repositories\VehiclesRepo;
use Finite\Exception\StateException;

class StartRaidCommand
{
    /** @var RaidsRepo */
    private $raidsRepo;
    
    /** @var VehiclesRepo */
    private $vehiclesRepo;

    public function __construct()
    {
        $this->raidsRepo = app('DriveRaidRepo');
        $this->vehiclesRepo = app('DriveVehiclesRepo');
    }

    public function createRaid($driver_id)
    {
        $vehicle = $this->vehiclesRepo->findActiveByDriver($driver_id);
        
        $this->validateAction($driver_id);
        
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

    private function validateAction($driver_id)
    {
        $raidExist = $this->raidsRepo->isExistRaid($driver_id);
        
        if ($raidExist) {
            throw new StateException('Вы уже участвуете в рейде');
        }
    }

}
