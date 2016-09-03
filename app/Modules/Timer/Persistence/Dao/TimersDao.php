<?php

namespace App\Modules\Timer\Persistence\Dao;

use App\Modules\Timer\Exceptions\TimerExpired_Exception;

class TimersDao
{
    protected $table = 'action_timers';

    public function create($user_id, $code, $dateTime)
    {
        return
            \DB::table($this->table)->insertGetId([
                'user_id' => $user_id,
                'action_code' => $code,
                'date_time' => $dateTime,
            ]);
    }

    /** @deprecated  */
    public function find($id)
    {
        $timer =
            \DB::table($this->table)
                ->select(['id', 'user_id', 'action_code', 'date_time'])
                ->find($id);

        return $timer;
    }

    public function findBy($user_id, $code)
    {
        $timer =
            \DB::table($this->table)
                ->select(['id', 'user_id', 'action_code', 'date_time'])
                ->selectRaw('TIMESTAMPDIFF(SECOND, now(), action_timers.date_time) AS duration_seconds')
                ->where('user_id', $user_id)
                ->where('action_code', $code)
                ->first();

        if (null === $timer) {
            throw new TimerExpired_Exception;
        }

        return $timer;
    }

    public function update($id, $newDateTime)
    {
        \DB::table($this->table)
            ->where('id', $id)
            ->update([
                'date_time' => $newDateTime,
            ]);
    }

    public function delete($id)
    {
        return
            \DB::table($this->table)
                ->delete($id);
    }
}
