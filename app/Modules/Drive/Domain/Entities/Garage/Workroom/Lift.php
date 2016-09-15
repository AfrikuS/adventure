<?php

namespace App\Modules\Drive\Domain\Entities\Workroom;

class Lift
{
    public $driver_id;
    public $level;

    public function __construct(\stdClass $liftData)
    {
        $this->driver_id = $liftData->driver_id;
        $this->level = $liftData->level;
    }
}
