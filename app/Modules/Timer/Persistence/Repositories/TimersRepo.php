<?php

namespace App\Modules\Timer\Persistence\Repositories;

use App\Modules\Timer\Domain\Entities\Timer;
use App\Modules\Timer\Persistence\Dao\TimersDao;
use Carbon\Carbon;

class TimersRepo
{
    /** @var TimersDao */
    private $timersDao;

    public function __construct(TimersDao $timersDao)
    {
        $this->timersDao = $timersDao;
    }

    public function findBy($user_id, $actionCode)
    {
        $timerData = $this->timersDao->findBy($user_id, $actionCode);

        $timer = new Timer($timerData);

        return $timer;
    }

    public function addTimer($user_id, $actionCode, $seconds)
    {
        $timerStr = Carbon::create()->addSeconds($seconds)->toDateTimeString();
        
        $this->timersDao->create($user_id, $actionCode, $timerStr);
    }

    public function delete($timer)
    {
       return $this->timersDao->delete($timer->id);
    }

    public function isExistBy($user_id, $actionCode)
    {
        return $this->timersDao->isExistBy($user_id, $actionCode);
    }
}
