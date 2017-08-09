<?php

namespace App\Modules\Dozor\Persistence\Repositories;

use App\Modules\Dozor\Domain\Entities\DozorQuest;
use App\Modules\Dozor\Persistence\RedisDao\DozorDao;

class DozorRepo
{
    /** @var DozorDao */
    private $dozorDao;

    public function __construct(DozorDao $dozorDao)
    {
        $this->dozorDao = $dozorDao;
    }

    public function initDozorData($user_id)
    {
        $dozorStatus = 'free'; // 'free', 'busy
        $timeDefault = 0;

        $this->dozorDao->createDozorEntry($user_id, $dozorStatus, $timeDefault);
    }

    public function updateAfterStartQuest($user_id, $datetime)
    {
        $this->dozorDao->updateStatusAndTime($user_id, DozorQuest::BUSY, $datetime);
    }

    public function updateAfterFinishQuest($user_id)
    {
        $this->dozorDao->updateStatusAndTime($user_id, DozorQuest::FREE, 0);
    }

    public function findDozorQuest($user_id)
    {

        $questData = $this->dozorDao->find($user_id);

        $quest = new DozorQuest($questData);


        return $quest;
    }
}
