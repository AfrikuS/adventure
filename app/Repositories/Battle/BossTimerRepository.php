<?php

namespace App\Repositories\Battle;

use App\Models\Battle\BossTimer;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\DB;

class BossTimerRepository
{
    public static function createTimer($bossId)
    {
        $currentDateTime = Carbon::create()->addSeconds(800)->toDateTimeString();

        return BossTimer::create([
            'boss_id' => $bossId,
            'date_time' => $currentDateTime,
        ]);
    }
    public static function getTimerBoss($bossId)
    {

        $timer = BossTimer::where('boss_id', $bossId)
            ->select(DB::raw('TIMESTAMPDIFF(SECOND, now(), mass_boss_timers.date_time) AS duration_seconds'))
            ->first();

        return $timer;
    }

}
