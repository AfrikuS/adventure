<?php

namespace App\Domain;

use App\Models\Mass\Boss;
use App\Repositories\Mass\BossRepository;
use App\Repositories\Mass\BossTimerRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MassActions
{
    public static function createBoss()
    {
        $userId = Auth::user()->id;

        DB::beginTransaction();
        try {
            $boss = BossRepository::create($userId);
            BossRepository::joinUserToAttackBoss($userId, $boss->id);
            BossTimerRepository::createTimer($boss->id);
        }
        catch (Exception $e) {

            DB::rollback();
        }
        DB::commit();
    }

    public static function joinToBoss($bossId)
    {
        $boss = Boss::find($bossId)->first();
        $boss->users_count = $boss->users_count + 1;

        $boss->users()->save(Auth::user());

        $boss->save();
    }
}
