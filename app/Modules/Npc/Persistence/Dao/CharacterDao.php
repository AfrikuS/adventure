<?php

namespace App\Modules\Npc\Persistence\Dao;

class CharacterDao
{
    private $table = 'npc_characters';

    public function get()
    {
        $charactersData = \DB::table($this->table)
            ->select(['id', 'name'])
            ->get();

        return $charactersData;
    }

    public function find($id)
    {
        $characterData = \DB::table($this->table)
            ->select(['id', 'name'])
            ->find($id);

        return $characterData;
    }

    public function create($name)
    {
        $char_id =
            \DB::table($this->table)
                ->insertGetId([
                    'name' => $name,
                ]);

        return $char_id;
    }
}
