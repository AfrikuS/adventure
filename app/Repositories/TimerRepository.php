<?php

namespace App\Repositories;

use App\Models\Action;
use App\Models\ActionTimer;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\DB;

class TimerRepository
{
    public static function getTimerByActionCode($actionCode, $user_id)
    {
        $res = ActionTimer::
            where('action_code', $actionCode)
            ->whereAnd('user_id', $user_id)
            ->select(['id'])
            ->selectRaw('TIMESTAMPDIFF(SECOND, now(), action_timers.date_time) AS duration_seconds')
            ->first();

        return $res;
    }

    public static function addTimer($actionCode, $user_id)
    {
        $timerStr = Carbon::create()->addSeconds(13)->toDateTimeString();

        $timer = ActionTimer::create([
            'action_code' => $actionCode,
            'user_id' => $user_id,
            'date_time' => $timerStr,
        ]);

        return $timer;
    }
}
