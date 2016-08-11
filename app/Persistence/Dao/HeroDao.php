<?php

namespace App\Persistence\Dao;

use App\Persistence\Models\Hero;

class HeroDao
{
    private $table = 'hero_resources';

    public function findById(int $user_id)
    {
        $hero = \DB::table($this->table)
            ->select('id', 'gold', 'oil', 'water')
            ->find($user_id);

        return new Hero($hero);
    }

    public function save(Hero $hero)
    {
        if ($hero->id != null) {

            \DB::table($this->table)
                ->where('id', $hero->id)
                ->update([
                    'gold' => $hero->gold,
                    'oil' => $hero->oil,
                    'water' => $hero->water,
                ]);
        }
    }

    public function create($user_id, $gold, $oil, $water)
    {
        \DB::table($this->table)->insert([
            'id' => $user_id,
            'gold' => $gold,
            'oil' => $oil,
            'water' => $water,
        ]);
    }

}
