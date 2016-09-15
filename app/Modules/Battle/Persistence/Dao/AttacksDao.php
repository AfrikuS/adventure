<?php

namespace App\Modules\Battle\Persistence\Dao;

class AttacksDao
{
    private $table = 'event_attacks';
    
    public function updateTimeout($atacker_id, $victim_id, $datetime)
    {
        return
            \DB::table('event_attacks')
                ->where('attack_user_id', $atacker_id)
                ->where('defense_user_id', $victim_id)
                ->update([
                    'attack_moment' => $datetime
                ]);
    }

    public function findLastAttack($atacker_id, $victim_id)
    {
        $attackData =
            \DB::table($this->table)
                ->select(['attack_user_id', 'defense_user_id'])
                ->where('attack_user_id', $atacker_id)
                ->where('defense_user_id', $victim_id)
//                ->pluck('id');
                ->first();
        
        return $attackData;
    }

    public function createAttackEvent($atacker_id, $victim_id, $dateTime)
    {
        return
            \DB::table($this->table)->insertGetId([
                'attack_user_id' => $atacker_id,
                'defense_user_id' => $victim_id,
                'defenser_user_name' => $victim_id . ' _ name',
                'attack_moment' => $dateTime,
            ]);
    }

    public function getLastAttacks($atacker_id, $limit)
    {
        $attacks = \DB::table($this->table . ' AS ea')
            ->select(['ea.defense_user_id', 'ea.attack_user_id', 'u.name'])
            ->addSelect(\DB::raw('TIMESTAMPDIFF(SECOND, now(), ea.attack_moment) AS duration_seconds'))
            ->join('users AS u', 'u.id', '=', 'ea.defense_user_id')
            ->where('ea.attack_user_id', $atacker_id)
            ->take($limit)
            ->orderBy('duration_seconds', 'desc')
            ->get();

        return $attacks;
    }
}
