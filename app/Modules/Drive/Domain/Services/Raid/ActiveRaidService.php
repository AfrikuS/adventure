<?php

namespace App\Modules\Drive\Domain\Services\Raid;

use App\Modules\Drive\Domain\Commands\Raid\FinishRaid;
use App\Modules\Drive\Domain\Entities\Driver;
use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Domain\Entities\Vehicle;
use App\Modules\Drive\Persistence\Repositories\DriversRepo;
use App\Modules\Drive\Persistence\Repositories\Raid\RaidsRepo;
use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;

class ActiveRaidService
{
    /** @var RaidsRepo */
    private $raidRepo;
    
    /** @var DriversRepo */
    private $driversRepo;

    public function __construct()
    {
        $this->raidRepo = app('DriveRaidRepo');
        $this->driversRepo = app('DriveDriversRepo');
    }

    public function completeRaid($raid_id)
    {
        $raid = $this->raidRepo->findByDriver($raid_id);
        
        $driver_id = $raid->id;

        

        $getReward = new IncrementGold($driver_id, $raid->reward);
        
        Bus::dispatch($getReward);

        
        $deleteRaid = new FinishRaid($raid->id);

        Bus::dispatch($deleteRaid);
    }

    public function startRobbery($raid_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findByDriver($raid_id);
        
        $raid->setStatusInRobbery();
        
        $this->raidRepo->updateRaidData($raid);
    }

    public function completeRobbery($raid_id)
    {
        /** @var Raid $raid */
        $raid = $this->raidRepo->findByDriver($raid_id);

        
        
        
        $raid->setStatusFree();

        $this->raidRepo->updateRaidData($raid);
    }

    public function startRaid(Vehicle $vehicle)
    {
        $startTime = Carbon::create()->toDateTimeString();

        $this->raidRepo->createRaid(
            $vehicle->driver_id, 
            $vehicle->id, 
            $startTime, 
            Raid::STATUS_FREE
        );
        
        $driver = $this->driversRepo->findById($vehicle->driver_id);
        
        $driver->status = Driver::STATUS_IN_RAID;
        
        $this->driversRepo->updateStatus($driver);
    }
}
