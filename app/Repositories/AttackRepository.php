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

    public static function insertAttackEvent($atacker_id, $defenser, Carbon $moment)
    {
        $attackExist = DB::table('event_attacks')
            ->whereExists(function($query) use($atacker_id, $defenser)
            {

                $query->select(DB::raw(1))
                    ->from('event_attacks')
                    ->where('defense_user_id', $defenser->id)
                    ->where('attack_user_id', $atacker_id);
            })
            ->get();

        if ($attackExist) {
            DB::table('event_attacks')
                ->where('attack_user_id', $atacker_id)
                ->where('defense_user_id', $defenser->id)
                ->update(['attack_moment' => $moment->toDateTimeString()]);
        }
        else {
            DB::table('event_attacks')->insert([
                'attack_user_id' => $atacker_id,
                'defense_user_id' => $defenser->id,
                'defenser_user_name' => $defenser->name,
                'attack_moment' => $moment->toDateTimeString(),
            ]);
        }
    }

    public static function deleteExpiredAttacks($atacker, $defensers)
    {
        
    }

    public static function getAttackedIdsBy($user_id)
    {
        $attackedUsersIds = DB::table('event_attacks')
            ->select('defense_user_id')
            ->where('attack_user_id', $user_id)
            ->where(DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment)'), '>', 0)
//            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment) AS duration_seconds'))
//            ->havingRaw('duration_seconds > 0')
            ->get();

        return $attackedUsersIds;
    }
}
