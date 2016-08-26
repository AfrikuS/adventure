<?php

namespace App\Commands\Railway\Conductor;

use App\Entities\Railway\ConductorSessionEntity;
use App\Models\Npc\ConductorSession;
use App\Models\Npc\HeroConductorRelation;
use App\Repositories\Railway\Station\ConductorRepo;

class TakeBonusThanksCmd
{
    /** @var ConductorRepo */
    protected $conductorRepo;

    public function __construct()
    {
        $this->conductorRepo = new ConductorRepo;
    }

    public function takeBonusThanks($hero_id, $conductor_id)
    {
        /** @var ConductorSessionEntity $meeting */
        $meeting = $this->conductorRepo->findMeetingByHeroId($hero_id);



        \DB::beginTransaction();
        try {

            $meeting->upperMood(5);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
