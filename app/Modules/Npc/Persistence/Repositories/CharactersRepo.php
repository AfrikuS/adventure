<?php

namespace App\Modules\Npc\Persistence\Repositories;

use App\Modules\Npc\Persistence\Dao\CharacterDao;

class CharactersRepo
{
    /** @var CharacterDao */
    private $characters;

    public function __construct(CharacterDao $characters)
    {
        $this->characters = $characters;
    }

    public function get()
    {
        $charactersData = $this->characters->get();
        
        return $charactersData;
    }

    public function create($name)
    {
        return $this->characters->create($name);
    }
}
