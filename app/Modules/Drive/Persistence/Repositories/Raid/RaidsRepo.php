<?php

namespace App\Modules\Drive\Persistence\Repositories\Raid;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Raid\Raid;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Persistence\Dao\Raid\RaidsDao;

class RaidsRepo
{
    /** @var RaidsDao */
    private $raidsDao;

    public function __construct(RaidsDao $raidsDao)
    {
        $this->raidsDao = $raidsDao;
    }

    public function createRaid($driver_id, $vehicle_id, string $startTime, $status)
    {
        return
            $this->raidsDao->create(
                $driver_id, 
                $vehicle_id,
                $status,
                $startTime,
                0
            );
    }
    
    public function findByDriver($driver_id)
    {
        $raid = EntityStore::get(Raid::class, $driver_id);

        if (null != $raid) {

            return $raid;
        }

        $raidData = $this->raidsDao->findBy($driver_id);


        $raid = new Raid($raidData);

        EntityStore::add($raid, $raid->id);

        return $raid;
    }

    public function deleteRaid($raid_id)
    {
        $this->raidsDao->delete($raid_id);
    }

    public function updateRaidData(Raid $raid)
    {
        $this->raidsDao->update(
            $raid->id,
            $raid->status,
            $raid->reward
        );
    }

    public function isExistRaid($id)
    {
        return $this->raidsDao->isExistRaid($id);
    }
}
