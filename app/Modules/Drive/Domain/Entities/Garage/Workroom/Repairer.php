<?php

namespace App\Modules\Drive\Domain\Entities\Garage\Workroom;

class Repairer
{
    const MAX_LEVEL = 3;

    public $driver_id;
    public $level;

    public function __construct(\stdClass $repairerData)
    {
        $this->driver_id = $repairerData->driver_id;
        $this->level = $repairerData->level;
    }

    public function isFullUpgrade()
    {
        return $this->level >= self::MAX_LEVEL;
    }

    public function upgradeLevel()
    {
        $this->level++;
    }
}
