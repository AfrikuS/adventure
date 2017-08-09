<?php

namespace App\Modules\Dozor\Domain\Entities;

use App\Helpers\TimeHelper;
use Carbon\Carbon;

class DozorQuest
{
    const FREE = 'free';
    const BUSY = 'busy';
    const PRIZE = 'prize';

    public $status;
    public $time;

    public function __construct(array $questData)
    {
        $this->checkStatus($questData);
    }

    private function checkStatus($questData)
    {

//        $this->user_id = $questData->id;
        $this->status = $questData['status'];
//
        $datetime = $questData['time'];
        $this->time = $datetime;
//
//        Carbon::createFromFormat($datetime, );



        if ($this->status === self::BUSY) {

            $dateQuestEnding = Carbon::createFromFormat('Y-m-d H:i:s', $datetime);

            if ($dateQuestEnding->isPast()) {

                $this->status = self::PRIZE;
                $this->time = 0;
            }
            else {
                
                $leftSceonds = TimeHelper::leftSecs($datetime);
                $this->time = $leftSceonds;
            }
        }

    }
}
