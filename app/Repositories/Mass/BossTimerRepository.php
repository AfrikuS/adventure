<?php

namespace App\Repositories\Mass;

use App\Models\Mass\BossTimer;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\DB;

class BossTimerRepository
{
    public static function createTimer($bossId)
    {
        $timer = new BossTimer();

        $currentDateTime = new DateTime();
        $currentDateTime->add(new DateInterval('PT' . 800 . 'S')); //секунд

        $timer->boss_id = $bossId;
        $timer->date_time = $currentDateTime->format("Y-m-d H:i:s");
        $timer->save();

        return $timer;
    }
    public static function getTimerBoss($bossId)
    {

        $timer = BossTimer::where('boss_id', '=', $bossId)
            ->select(DB::raw('TIMESTAMPDIFF(SECOND, now(), mass_boss_timers.date_time) AS duration_seconds'))
            ->first();

        return $timer;
    }

    public static function delete($bossId)
    {
//        $timer = ORM::for_table('boss_timers')->where('boss_id', $bossId)->find_one();

        $timer = BossTimer::where('boss_id', '=', $bossId)->first();

        if ($timer) {
            return $timer->delete();
        }

//        $sql = 'DELETE FROM boss_timers WHERE boss_id = :boss_id';
//        $res = ORM::for_table('boss_timers')
//            ->raw_execute($sql, ['boss_id' => $bossId]);

        return false;
//            ->raw_query($sql, ['actionCode' => $actionCode, 'userId' => $userId])
//        if ($timer) {  $timer->delete(); }
    }
}
