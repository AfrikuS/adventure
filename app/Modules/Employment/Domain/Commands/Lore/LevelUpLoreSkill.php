<?php

namespace App\Modules\Employment\Domain\Commands\Lore;

class LevelUpLoreSkill
{
    public $lore_id;
    public $skillIndex;

    public function __construct(int $lore_id, int $skillIndex)
    {
        $this->lore_id = $lore_id;

        $this->skillIndex = $skillIndex;
    }
}
