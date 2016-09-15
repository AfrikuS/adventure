<?php

namespace App\Modules\Drive\Domain\Entities\Garage\Workroom;

class Refueler
{
    const MAX_LEVEL = 6;

    public $driver_id;
    public $level;

    public function __construct(\stdClass $refuelerData)
    {
        $this->driver_id = $refuelerData->driver_id;
        $this->level = $refuelerData->level;
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
