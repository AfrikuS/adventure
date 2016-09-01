<?php

namespace App\Modules\Drive\Persistence\Repositories\Raid;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Persistence\Dao\Raid\RaidsDao;

class RobberyRepo
{
    /** @var RaidsDao */
    private $raidsDao;

    public function __construct()
    {
        $this->raidsDao = app('DriveRaidsDao');
    }
    
    public function findByRaid($raid_id)
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

    public function updateRobberyData(Robbery $robbery)
    {
        return
            $this->raidsDao->updateRobberyData(
                $robbery->id,
                $robbery->status,
                $robbery->robbery_status,
                $robbery->victim_id
            );
    }

    public function delete($robery_id)
    {
        $this->raidsDao->deleteRobbery($robery_id);
    }
}
