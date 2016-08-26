<?php

namespace App\Commands\Railway\Conductor;

use App\Entities\Railway\ConductorSessionEntity;
use App\Models\Npc\HeroConductorRelation;
use App\Repositories\Railway\Station\ConductorRepo;

class TakeRegularBribeCmd
{
    /** @var ConductorRepo */
    protected $conductorRepo;

    public function __construct()
    {
        $this->conductorRepo = new ConductorRepo;
    }

    public function takeRegularBribe($hero_id, $conductor_id)
    {
//        /** @var HeroConductorRelation $relation */
//        $relation = $this->conductorRepo->findHeroRelation($hero_id, $conductor_id);

        /** @var ConductorSessionEntity $meeting */
        $meeting = $this->conductorRepo->findMeetingByHeroId($hero_id);

        
        
        \DB::beginTransaction();
        try {

//            $relation->increment('respect_level', 3);

            $meeting->upperMood(3);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
