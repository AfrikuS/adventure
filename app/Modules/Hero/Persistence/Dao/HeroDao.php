<?php

namespace App\Modules\Hero\Persistence\Dao;

use App\Persistence\Models\Hero;

class HeroDao
{
    private $table = 'hero_resources';

    public function findById(int $user_id)
    {
        $heroData = \DB::table($this->table)
            ->select('id', 'gold', 'oil', 'water')
            ->find($user_id);

        return $heroData;
    }

    public function update($hero_id, $gold, $oil, $water)
    {
        return
            \DB::table($this->table)
                ->where('id', $hero_id)
                ->update([
                    'gold' => $gold,
                    'oil' => $oil,
                    'water' => $water,
                ]);
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
