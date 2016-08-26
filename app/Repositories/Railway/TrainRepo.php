<?php

namespace App\Repositories\Railway;

use App\Models\Railway\TransitTrain;

class TrainRepo
{
    public function finById($id): TransitTrain
    {
        return TransitTrain::select('id', 'conductor_id', 'kind', 'status', 'start_time', 'end_time')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds')
//            ->havingRaw('duration_seconds > 0')
            ->find($id);
    }

    public function findByMeetingId($meeting_id)
    {
/*        return TransitTrain::select('id', 'conductor_id', 'kind', 'status', 'start_time', 'end_time')
            ->join
            ->where()


            ->havingRaw('duration_seconds > 0')
            ->first();*/


        $train = \DB::table('railway_transit_trains as tr')
            ->join('npc_conductor_hero_meetings AS mets', 'mets.train_id', '=', 'tr.id')
            ->select('tr.id', 'tr.conductor_id', 'tr.kind', 'tr.status', 'tr.start_time', 'tr.end_time')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), tr.end_time) AS duration_seconds')
            ->where('mets.id', $meeting_id)
            ->having('duration_seconds', '>', 0)
            ->first();
        
        return $train;
    }

    public function deleteTrain($train)
    {
        return TransitTrain::destroy($train->id);
    }

//    public function finByHeroId($hero_id)
//    {
//        return TransitTrain::select('id', 'conductor_id', 'kind', 'status', 'start_time', 'end_time')
//            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds')
//            ->where('hero_id', $hero_id)
//            ->havingRaw('duration_seconds > 0')
//            ->first();
//    }
}
