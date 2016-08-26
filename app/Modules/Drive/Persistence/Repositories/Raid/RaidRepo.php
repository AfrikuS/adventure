<?php

namespace App\Modules\Drive\Persistence\Repositories\Raid;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Persistence\Dao\Raid\RaidsDao;

class RaidRepo
{
    /** @var RaidsDao */
    private $raidsDao;

    public function __construct()
    {
        $this->raidsDao = app('DriveRaidsDao');
    }

    public function createRaid($driver_id, $vehicle_id, string $startTime)
    {
        $this->raidsDao->create($driver_id, $vehicle_id, $startTime);
    }
    
    public function findSimpleRaid($driver_id)
    {
        $raid = EntityStore::get(Raid::class, $driver_id);

        if (null != $raid) {

            return $raid;
        }

        $raidData = $this->raidsDao->findSimpleRaidByDriver($driver_id);


        $raid = new Raid($raidData);

        EntityStore::add($raid, $raid->id);

        return $raid;
    }

    /** @deprecated @see RobberyRepo */
    public function findRobbery($raid_id)
    {
        $robbery = EntityStore::get(Robbery::class, $raid_id);

        if (null != $robbery) {

            return $robbery;
        }

        $robberyData = $this->raidsDao->findRobbery($raid_id);


        $robbery = new Robbery($robberyData);

        EntityStore::add($robbery, $robbery->id);


        return $robbery;
    }

    public function deleteRaid($raid_id)
    {
        $this->raidsDao->delete($raid_id);
    }


//    /** @deprecated @see RobberyRepo */
//    public function updateRobberyData($raid)
//    {
//        return
//            $this->raidsDao->updateRobberyData(
//                $raid->id,
//                $raid->status,
//                $raid->robbery_status
//            );
//    }

    public function updateRaidData(Raid $raid)
    {
        $this->raidsDao->updateRaidData(
            $raid->id,
            $raid->status,
            $raid->victim_id,
            $raid->reward
        );
    }
}
