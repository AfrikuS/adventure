<?php

namespace App\Modules\Drive\Domain\Commands\Raid;

class DeleteRaid
{
    public $raid_id;

    public function __construct($raid_id)
    {
        $this->raid_id = $raid_id;
    }
}
