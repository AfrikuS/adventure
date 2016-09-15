<?php

namespace App\Modules\Npc\Domain\Entities;

use Carbon\Carbon;

class NpcDeal
{
    const STATUS_STARTED = 'started';
    const STATUS_NO_STATUS = 'no_status';
    const STATUS_FINISHED = 'finished';

    public $id;
    public $hero_id;
    public $npc_char;
    public $task;
    public $reward;
    public $deal_status;
    public $deal_ending;

    public function __construct(\stdClass $npcDealData)
    {
        $this->id = $npcDealData->id;
        $this->hero_id = $npcDealData->hero_id;
        $this->npc_char = $npcDealData->npc_char;
        $this->task = $npcDealData->task;
        $this->reward = $npcDealData->reward;
        $this->deal_status = $npcDealData->deal_status;
        $this->deal_ending = $npcDealData->deal_ending;
    }

    public function isDealExpired()
    {
        return Carbon::parse($this->deal_ending)->isPast();
    }

    public function init(Carbon $dealEnding)
    {
        $this->deal_status = self::STATUS_STARTED;
        
        $this->deal_ending = $dealEnding->toDateTimeString();
    }

    public function perform()
    {
        $this->deal_status = self::STATUS_FINISHED;
    }
}
