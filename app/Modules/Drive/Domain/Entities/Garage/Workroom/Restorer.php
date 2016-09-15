<?php

namespace App\Modules\Drive\Domain\Entities\Workroom;

class Restorer
{
    public $driver_id;
    public $level;

    public function __construct(\stdClass $restorerData)
    {
        $this->driver_id = $restorerData->driver_id;
        $this->level = $restorerData->level;
    }
}
