<?php

namespace App\Repositories\Macro;

use App\Models\Action;
use App\Models\ActionTimer;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\DB;

class TimerRepository
{
    public static function getTimer($actionCode, $userId)
    {
        $res = DB::table('timers')
            ->leftJoin('actions', 'actions.id', '=', 'timers.action_id')
//            ->leftJoin('theatre_spectacle_roles as roles', 'rels.role_id', '=', 'roles.id')
            ->where('actions.code', $actionCode)
            ->where('timers.user_id', $userId)
            ->select('timers.id')
            ->addSelect('timers.action_id')
            ->addSelect(DB::raw('SIGN(TIMESTAMPDIFF(SECOND, now(), timers.date_time))  AS status_int'))
            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), timers.date_time) AS duration_seconds'))
//            ->addSelect('SIGN(TIMESTAMPDIFF(SECOND, now(), timers.date_time))  AS status_int')
//            ->addSelect('TIMESTAMPDIFF(SECOND, now(), timers.date_time) AS duration_seconds')
//            ->orderBy('actors.name')
            ->first();

        return $res;

    }

    public static function delete($idTimer)
    {
        $timer = ActionTimer::find($idTimer);
        if ($timer) {  $timer->delete(); }
    }

    public static function addTimer($actionCode, $userId)
    {
        $action = Action::where('code', '=', $actionCode)->first();
//        $action = ORM::for_table('actions')->where('code', $actionCode)->find_one();



        if (!$action) return false;

        $timer = new ActionTimer();

        $currentDateTime = new DateTime();
        $currentDateTime->add(new DateInterval('PT' . $action->duration_seconds . 'S')); //секунд

        $timer->action_id = $action->id;
        $timer->user_id  = $userId;
        $timer->date_time = $currentDateTime->format("Y-m-d H:i:s");

        return $timer->save();
    }




}
