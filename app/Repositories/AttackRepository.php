<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// danger pron-code
class AttackRepository
{

    public static function getLastAttacks($user_id)
    {
        $attacks = DB::table('event_attacks')
            ->select(['defense_user_id', 'defenser_user_name', 'attack_user_id'])
//            ->leftJoin('users', 'event_attacks.defense_user_id', 'users.id')
            ->where('attack_user_id', $user_id)
//            ->addSelect('users.name AS user_name')
            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment) AS duration_seconds'))
            ->get();
        
        return $attacks;
    }

    public static function deleteExpiredAttacks($atacker, $defensers)
    {
        
    }

}
