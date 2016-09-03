<?php

namespace App\Modules\Timer\Domain\Entities;

class Timer
{
    public $id;
    public $user_id;
    public $code;
    public $duration_seconds;

    public function __construct(\stdClass $timerData)
    {
        $this->id = $timerData->id;
        $this->user_id = $timerData->user_id;
        $this->code = $timerData->action_code;
        $this->duration_seconds = $timerData->duration_seconds;
    }

    private function transferTimeToSeconds()
    {
    }
    
    public function isActive()
    {
        return $this->duration_seconds > 0;
    }

    public function isExpired()
    {
        return ! $this->isActive();
    }
}
