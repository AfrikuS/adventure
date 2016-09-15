<?php

namespace App\Modules\Npc\Domain\Entities;

use Carbon\Carbon;

class NpcOffer
{
    // NpcOfferEntity
    const STATUS_CREATED = 'created';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_EXPIRED = 'expired';
    const STATUS_SHOWN = 'shown';

    public $id;
    public $hero_id;
    public $npc_char;
    public $task;
    public $reward;
    public $offer_status;
    public $offer_ending;

    public function __construct(\stdClass $npcOfferData)
    {
        $this->id = $npcOfferData->id;
        $this->hero_id = $npcOfferData->hero_id;
        $this->npc_char = $npcOfferData->npc_char;
        $this->task = $npcOfferData->task;
        $this->reward = $npcOfferData->reward;
        $this->offer_status = $npcOfferData->offer_status;
        $this->offer_ending = $npcOfferData->offer_ending;
    }

    public function isOfferExpired()
    {
        return Carbon::parse($this->offer_ending)->isPast();
    }

    public function tooLongWait()
    {
//        if ($this->stateMachine->can('too_long_wait')) {
//            $this->stateMachine->apply('too_long_wait');

        $this->offer_status = self::STATUS_EXPIRED;
    }

    public function show()
    {
//        if ($this->stateMachine->can('show')) {
//            $this->stateMachine->apply('show');

        $this->offer_status = self::STATUS_SHOWN;
    }

    public function accept()
    {
//        if ($this->stateMachine->can('accept')) {
//            $this->stateMachine->apply('accept');

//            $this->model->update([
                $this->offer_status = self::STATUS_ACCEPTED;
    }

    public function initTimeCounter(Carbon $offerEnding)
    {
        $this->offer_ending = $offerEnding->toDateTimeString();
    }

}
