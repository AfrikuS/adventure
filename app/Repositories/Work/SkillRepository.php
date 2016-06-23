<?php

namespace App\Repositories\Work;

use App\Models\Work\Order;
use App\Models\Work\WorkSkill;
use App\Models\Work\WorkUserSkill;

class SkillRepository
{

    public static function getSkillsByOrder(Order $order)
    {
        return [];
    }

    /** @deprecated  see team-worker-repo */
    public static function addSkillToUserByCode($worker, string $skillCode)
    {
        $userSkill = WorkUserSkill::
            select('id', 'value')
            ->firstOrCreate(['worker_id' => $worker->id, 'code' => $skillCode]);

        $userSkill->increment('value', 11);
    }

    public static function getUserSkills($user)
    {
        return WorkUserSkill::
            select('id', 'code', 'value')
            ->where('worker_id', $user->id)
            ->get();
    }
}
