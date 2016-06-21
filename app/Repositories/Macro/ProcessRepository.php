<?php

namespace App\Repositories\Macro;

use App\Models\Macro\Timer;
use Illuminate\Support\Facades\DB;

class ProcessRepository
{
    public static function activeEmployments($user_id)
    {
//        $timers = DB::table('macro_timers')
//            ->where('macro_timers.user_id', '=', $user_id)
//            ->select('macro_timers.id AS id')
//            ->addSelect('macro_timers.kind AS kind')
//            ->addSelect('macro_timers.people_count AS count')
//            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), macro_timers.date_time) AS duration_seconds'))
//            ->havingRaw('duration_seconds > 0')
//            ->get();

        $timers = Timer::
            select(['id', 'kind', 'people_count'])
            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), macro_timers.date_time) AS duration_seconds'))
            ->havingRaw('duration_seconds > 0')
            ->get();

        return $timers;
    }
}
