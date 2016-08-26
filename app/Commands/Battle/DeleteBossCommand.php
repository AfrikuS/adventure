<?php

namespace App\Commands\Battle;

use App\Deleters\BattleDeleter;
use App\Models\Battle\Boss;
use App\Models\Battle\BossTimer;

class DeleteBossCommand
{
    public function deleteBoss(Boss $boss)
    {
        \DB::transaction(function () use ($boss) {
            
            $this->deleteTimer($boss->id);
            
            BattleDeleter::deleteTimer($boss->id);

            $boss->users()->detach();
            $boss->delete();
        });

    }

    private function deleteTimer($bossId)
    {
        $timer = BossTimer::where('boss_id', $bossId)->first();

        if ($timer) {
            return $timer->delete();
        }

        return false;
    }

}
