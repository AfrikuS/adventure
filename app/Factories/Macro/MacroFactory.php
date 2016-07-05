<?php

namespace App\Factories\Macro;

use App\Models\Macro\Resources;

class MacroFactory
{
    public static function createPolitic($user_id)
    {
        return Resources::create([
            'id' => $user_id,
            'food' => 5000,
            'tree' => 9000,
            'water' => 4000,
            'free_people' => 700,
        ]);
    }
}
