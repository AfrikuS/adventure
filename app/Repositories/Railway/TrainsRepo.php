<?php

namespace App\Repositories\Railway;

use App\Models\Railway\TransitTrain;

class TrainsRepo
{
    public function getNearTrains()
    {
        return TransitTrain::
            select('id', 'conductor_id', 'kind', 'status', 'start_time', 'end_time')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), start_time) AS duration_seconds')
            ->havingRaw('duration_seconds > 0')
            ->get();
    }

    public function getActiveTrains()
    {
        return TransitTrain::
            select('id', 'conductor_id', 'kind', 'status', 'start_time', 'end_time')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), start_time) AS active_seconds')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds')
            ->havingRaw('active_seconds < 0')
            ->havingRaw('duration_seconds > 0')
            ->with('conductor')
            ->get();
    }

    public function getOldTrains()
    {
        return TransitTrain::
            select('id')
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), end_time) AS duration_seconds')
            ->havingRaw('duration_seconds < 0')
            ->get();
    }

    public function createTrain($conductorId, $startTime, $endTime)
    {
        return 
            TransitTrain::create([
            'conductor_id' => $conductorId,
            'kind' => 'kinder',
            'status' => 'transit',
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
    }
}
