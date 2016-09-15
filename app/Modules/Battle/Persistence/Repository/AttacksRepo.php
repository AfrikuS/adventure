<?php

namespace App\Modules\Battle\Persistence\Repository;

use App\Modules\Battle\Persistence\Dao\AttacksDao;
use Carbon\Carbon;

class AttacksRepo
{
    /** @var AttacksDao */
    private $attacksDao;

    public function __construct(AttacksDao $attacksDao)
    {
        $this->attacksDao = $attacksDao;
    }

    public function addAttackEvent($atacker_id, $victim_id, Carbon $timemout)
    {
        $attackData = $this->attacksDao->findLastAttack($atacker_id, $victim_id);
        
        if (null !== $attackData) {
            
            $this->attacksDao->updateTimeout(
                $atacker_id,
                $victim_id,
                $timemout->toDateTimeString());
        }
        else {
            
            $this->attacksDao->createAttackEvent($atacker_id, $victim_id, $timemout->toDateTimeString());
        }
    }

    public function getLastAttacks($user_id)
    {
        $attacksData = $this->attacksDao->getLastAttacks($user_id, 5);
        
        return $attacksData;
    }


    /** @deprecated */
    public function getAttackedIdsByUserId($user_id)
    {
        $attackedUsersIds = \DB::table('event_attacks')
            ->select('defense_user_id')
            ->where('attack_user_id', $user_id)
            ->where(\DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment)'), '>', 0)
//            ->addSelect(DB::raw('TIMESTAMPDIFF(SECOND, now(), event_attacks.attack_moment) AS duration_seconds'))
//            ->havingRaw('duration_seconds > 0')
            ->get();

        return $attackedUsersIds;
    }
}
