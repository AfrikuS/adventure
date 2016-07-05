<?php

namespace App\Deleters;

use App\Models\Battle\Boss;
use App\Models\Battle\BossTimer;
use App\Repositories\Battle\BossRepository;
use App\Repositories\Battle\BossTimerRepository;

class BattleDeleter
{
    public static function deleteBoss(Boss $boss)
    {
        \DB::transaction(function () use ($boss) {
            BattleDeleter::deleteTimer($boss->id);

            $boss->users()->detach();
            $boss->delete();
        });

    }

    public static function deleteTimer($bossId)
    {
        $timer = BossTimer::where('boss_id', $bossId)->first();

        if ($timer) {
            return $timer->delete();
        }

        return false;
    }

}
