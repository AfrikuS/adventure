<?php

namespace App\Commands\Railway\Train;

use App\Entities\Npc\NpcRelation;
use App\Entities\Railway\ConductorSessionEntity;
use App\Models\Npc\ConductorSession;
use App\Models\Npc\HeroConductorRelation;
use App\Repositories\Railway\Station\ConductorRepo;

class FinishConductorSessionCmd
{
    /** @var ConductorRepo */
    protected $conductorRepo;

    public function __construct()
    {
        $this->conductorRepo = new ConductorRepo;
    }

    public function finishSession(int $hero_id, ConductorSessionEntity $session)
    {
        /** @var HeroConductorRelation $relation */
        $conductorRelation = $this->conductorRepo->findHeroRelation($hero_id, $session->conductor_id);

        $moodPoints = $session->mood;


        $conductorRelation->upReputation($moodPoints);
    }
}
