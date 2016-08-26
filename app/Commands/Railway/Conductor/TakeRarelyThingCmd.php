<?php

namespace App\Commands\Railway\Conductor;

use App\Entities\Railway\ConductorSessionEntity;
use App\Models\Npc\HeroConductorRelation;
use App\Repositories\Railway\Station\ConductorRepo;

class TakeRarelyThingCmd
{
    /** @var ConductorRepo */
    protected $conductorRepo;

    public function __construct()
    {
        $this->conductorRepo = new ConductorRepo;
    }

    public function takeRarelyThing($hero_id, $conductor_id)
    {
        /** @var ConductorSessionEntity $meeting */
        $meeting = $this->conductorRepo->findMeetingByHeroId($hero_id);



        \DB::beginTransaction();
        try {

            $meeting->upperMood(7);


        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
