<?php

namespace App\Repositories\Railway\Station;

use App\Entities\Npc\NpcRelation;
use App\Entities\Railway\ConductorSessionEntity;
use App\Exceptions\NullObjectException;
use App\Models\Npc\ConductorSession;
use App\Models\Npc\HeroConductorRelation;
use Carbon\Carbon;

class ConductorRepo
{
    public function findHeroRelation($hero_id, $conductor_id)
    {
        $relation = HeroConductorRelation::
            where('hero_id', $hero_id)
            ->where('conductor_npc_id', $conductor_id)
            ->with('conductor')
            ->first();

        if (null == $relation) {
            $relation = $this->createHeroRelation($hero_id, $conductor_id);
        }
        
        return new NpcRelation($relation);
    }

    /** @deprecated */
    public function findMeetingWithTrainByHeroId($hero_id)
    {
        $query = $this->findSessionQuery();
        $session = $query->with('train')->find($hero_id);

        return $session;

/*        $meeting = ConductorSession::
            select('hero_id', 'conductor_id', 'train_id', 'mood', 'end_time')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds')
            ->where('hero_id', $hero_id)
            ->with('train')
            ->first();*/
        
//        return $meeting;
    }

    public function findMeetingByHeroId($hero_id)
    {
        $query = $this->findSessionQuery();
        $session = $query->with('conductor')->find($hero_id);


        if (null == $session) {
            
            return null;
            
            throw new NullObjectException('ConductorSession');
        }

        return new ConductorSessionEntity( $session );
    }

    public function deleteSession($meeting)
    {
        ConductorSession::destroy($meeting->hero_id);
    }

    private function findSessionQuery()
    {
        return ConductorSession::
            select('hero_id', 'conductor_id', 'train_id', 'mood', 'end_time')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds');
//            ->where('hero_id', $hero_id)
    }

    private function createHeroRelation($hero_id, $conductor_id)
    {
        return HeroConductorRelation::create([
            'hero_id' => $hero_id,
            'conductor_npc_id' => $conductor_id,
            'respect_level' => 0,
            'drain_oil_price' => 10, 
            'drain_petrol_price' => 14,
        ]);
    }

    public function createMeetingWithHero($hero_id, $conductor_id, $train_id, $endTime)
    {
        return ConductorSession::create([
            'hero_id' => $hero_id,
            'conductor_id' => $conductor_id,
            'mood' => 20,
            'train_id' => $train_id,
            'end_time' => $endTime,
        ]);
    }
}
