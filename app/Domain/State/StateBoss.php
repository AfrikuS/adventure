<?php

namespace App\Domain\State;

use App\Repositories\Battle\BossRepository;
use App\Repositories\Battle\BossTimerRepository;

class StateBoss //implements IState
{
    private $userID;
    private $boss;
    private $states;

    function __construct($userId)
    {
        $this->userID = $userId;
        $this->boss = BossRepository::getBossByUserId($userId);
        $this->states = [
            'NO_BOSS',
//            'USER_JOINED_BUT_NOT_WORK_YET',
            'BOSS_PROCESS',
            'BOSS_END'
        ];
    }

    public function getCurrentState()
    {
        if ($this->boss)
        {
            $timer = BossTimerRepository::getTimerBoss($this->boss->id);

            if ($timer)
            {
                if ($timer->duration_seconds <= 0)
                {
                    return 'BOSS_END';
                }
                else {
                    return 'BOSS_PROCESS';
                }

            }
            else { // игра с одним пользователем, сам создаю сам работаю
                return 'BOSS_PROCESS';
            }

        }
        else {
            return 'NO_BOSS';
        }

    }
}
