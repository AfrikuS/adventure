<?php

namespace App\Modules\Auction\Domain\Entities;

class Thing
{
    const STATUS_FREE = 'free';
    const STATUS_LOCKED = 'locked';
    
    public $id;
    public $title;
    public $status;
    public $owner_id;

    public function __construct(\stdClass $thingData)
    {
        $this->id = $thingData->id;
        $this->title = $thingData->title;
        $this->status = $thingData->status;
        $this->owner_id = $thingData->owner_id;
    }

    public function lock()
    {
        $this->status = self::STATUS_LOCKED;
    }

    public function unlock()
    {
        $this->status = self::STATUS_FREE;
    }

    public function changeOwner(int $newOwner_id)
    {
        $this->owner_id = $newOwner_id;
    }
}
