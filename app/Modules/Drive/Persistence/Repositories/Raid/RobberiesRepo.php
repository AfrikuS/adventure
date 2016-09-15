<?php

namespace App\Modules\Drive\Persistence\Repositories\Raid;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Raid\Robbery;
use App\Modules\Drive\Persistence\Dao\Raid\RaidsDao;
use App\Modules\Drive\Persistence\Dao\Raid\RobberiesDao;
use Carbon\Carbon;

class RobberiesRepo
{
    /** @var RobberiesDao */
    private $robberiesDao;

    public function __construct(RobberiesDao $robberiesDao)
    {
        $this->robberiesDao = $robberiesDao;
    }
    
    public function findByRaid($raid_id)
    {
        $robbery = EntityStore::get(Robbery::class, $raid_id);

        if (null != $robbery) {

            return $robbery;
        }

        $robberyData = $this->robberiesDao->find($raid_id);


        $robbery = new Robbery($robberyData);

        EntityStore::add($robbery, $robbery->id);

        return $robbery;
    }

    public function updateRobberyData(Robbery $robbery)
    {
        return
            $this->robberiesDao->update(
                $robbery->id,
                $robbery->status,
                $robbery->victim_id
            );
    }

    public function updateVictim(Robbery $robbery)
    {
        return
            $this->robberiesDao->update(
                $robbery->id,
                $robbery->status,
                $robbery->victim_id
            );
    }

    public function delete($robbery_id)
    {
        $this->robberiesDao->delete($robbery_id);
    }

    public function create($raid_id, $vehicle_id, $status)
    {
        $startedAt = Carbon::create()->toDateTimeString();

        $this->robberiesDao->create(
            $raid_id,
            $vehicle_id,
            $status,
            $startedAt,
            null
        );
    }
}
