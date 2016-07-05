<?php

namespace App\Factories;

use App\Models\Mine\Miner;

class MineFactory
{
    public static function createMiner($user): Miner
    {
        return Miner::create([
            'id' => $user->id,
            'petrol' => 0,
            'kerosene' => 0,
            'oil' => 0,
            'whater' => 0,
        ]);
    }
}
