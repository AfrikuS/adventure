<?php

namespace App\Modules\Npc\Domain\Entities;

class Character
{
    public $id;
    public $name;

    public function __construct(\stdClass $characterData)
    {
        $this->id = $characterData->id;
        $this->name = $characterData->name;
    }
}
