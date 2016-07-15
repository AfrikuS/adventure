<?php

namespace App\Lib\Drive\Raid;

use App\Entities\Drive\RaidEntity;

class VictimFinder
{
    public function findVictim(RaidEntity $raid)
    {
        return $raid->id;
    }
}
