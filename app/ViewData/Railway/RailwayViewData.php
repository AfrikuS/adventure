<?php

namespace App\ViewData\Railway;

use App\Models\Npc\ConductorSession;
use App\Repositories\Railway\Station\ConductorRepo;

class RailwayViewData
{
    /** @var ConductorRepo */
    private $conductorRepo;

    public function __construct(ConductorRepo $conductorRepo)
    {
        $this->conductorRepo = $conductorRepo;
    }

    public function selectMeetingConductor($hero_id)
    {
        /** @var ConductorSession $meeting */
        $meeting = $this->conductorRepo->findMeetingByHeroId($hero_id);

        $conductor_id = $meeting->conductor_id;

        $conductorRel = $this->conductorRepo->findHeroRelation($hero_id, $conductor_id);

        
        return new MeetingConductorDto(
                            $conductorRel->conductor->id,
                            $conductorRel->conductor->name,
                            $conductorRel->respect_level,
                            $meeting->mood
                        );

    }
}
