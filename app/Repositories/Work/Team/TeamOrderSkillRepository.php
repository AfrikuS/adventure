<?php

namespace App\Repositories\Work\Team;

use App\Models\Work\Order;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderSkill;
use App\Models\Work\WorkSkill;
use App\Models\Work\WorkUserSkill;
use Illuminate\Database\Eloquent\Collection;

class TeamOrderSkillRepository
{
    /**
     *
     * @param  TeamOrder $order
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @deprecated 
     */
    public static function getOrderSkills(TeamOrder $order): Collection
    {
        $orderSkills = TeamOrderSkill::
            select('id', 'code', 'need_times', 'stock_times')
            ->where('teamorder_id', $order->id)
            ->get();

        return $orderSkills;
    }

//    /** @deprecated  */
//    public static function getOrderSkillByCode(TeamOrder $order, string $skillCode): TeamOrderSkill
//    {
//        return $order->materialByCode($skillCode);
//    }

    public static function deleteStockedSkill(TeamOrderSkill $skill)
    {
        TeamOrderSkill::destroy($skill->id);
    }

    /*
    
        public static function addSkillToUserByCode($user, string $skillCode)
        {
            $userSkill = WorkUserSkill::
                select('id', 'value')
                ->firstOrCreate(['user_id' => $user->id, 'code' => $skillCode]);
    
            $userSkill->increment('value', 11);
        }
    
        public static function getUserSkills($user)
        {
            return WorkUserSkill::
                select('id', 'code', 'value')
                ->where('user_id', $user->id)
                ->get();
        }*/


}
