<?php

namespace App\Modules\Auction\Domain\Entities;

class Lot
{
    public $id;
    public $owner_id;
    public $thing_id;
    public $bid;

    public $thing;

    public function __construct(\stdClass $lotData)
    {
        $this->id = $lotData->id;
        $this->owner_id = $lotData->owner_id;
        $this->thing_id = $lotData->thing_id;
        $this->bid = $lotData->bid;
    }

    public function setThing($thing)
    {
        $this->thing = $thing;
    }
}
