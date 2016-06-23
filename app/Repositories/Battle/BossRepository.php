<?php

namespace App\Repositories\Battle;

use App\Models\Battle\Boss;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BossRepository
{
    public static function create($userId)
    {
        $boss = new Boss();
        $boss->user_id = $userId;
        $boss->save();

        return $boss;
    }

    public static function joinUserToAttackBoss($userId, $bossId)
    {
    }

    public static function addKick($userId)
    {
        $boss = BossRepository::getBossByUserId($userId);
        $boss->kicks = $boss->kicks + 1;
        $boss->save();
    }

    public static function getBossByUserId($userId)
    {
        $user = User::find($userId);
        $boss = $user->boss->first();

        if ($boss) {
            return $boss;
        }
//        $bossUserRel = ORM::for_table('boss_users')->where('user_id', $userId)->find_one();
//        if ($bossUserRel) {
//
//            $boss = ORM::for_table('attack_bosses')->find_one($bossUserRel->get('boss_id'));
//
//            return $boss;
//        }

        return false;
    }

    public static function deleteByOwner($userId)
    {

        $boss = Boss::where('user_id', '=', $userId)->first();
        $boss->delete();
    }
    public static function delete($massId)
    {
        $boss = Boss::find($massId);

        $boss->delete();
    }

    public static function getUsers($bossId)
    {

        $workers = Boss::find($bossId)->users;

//        $workers = ORM::for_table('users')
//            ->select('id')
//            ->select('name')
//            ->join('boss_users', 'users.id = boss_users.user_id')
//            ->where('boss_users.boss_id', $bossId)
//            ->find_array();

        return $workers;
    }

    public static function deleteUsers($bossId)
    {
        Boss::find($bossId)->users()->detach();
//        DB::delete('delete from toy_user where toy_id = ? AND user_id = ? AND status = 0', array($toy->id,Auth::id()));
//        ORM::for_table('mass_boss_users_rels')->where('boss_id', $bossId)->delete_many();
    }

    public static function getAll()
    {
        // select mass_works_users.mass_id, COUNT(user_id) as count from mass_works_users GROUP BY mass_id;

        $bosses = Boss::where('users_count', '<', 3)->get();
//        $bosses = DB::table('mass_boss_users_rels')
//            ->select('boss_id')
//            ->addSelect(DB::raw('COUNT(user_id) AS count'))
//            ->groupBy('boss_id')
//            ->havingRaw('count < 3')
//            ->get();

//        $bosses = ORM::for_table('mass_boss_users_rels')
//            ->select('boss_id')
//            ->select_expr('COUNT(user_id)', 'count')
//            ->group_by('boss_id')
//            ->having_lt('count', 3)
//            ->find_many();

        return $bosses;
    }

}
