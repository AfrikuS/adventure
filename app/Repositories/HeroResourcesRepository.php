<?php

namespace App\Repositories;

use App\Models\Hero\Resources;
use App\Models\User;

class HeroResourcesRepository
{
    public static function addGoldToUser($user, $value)
    {
        Resources::find($user->id, ['id', 'gold'])->increment('gold', $value);
    }

    public static function subtractGoldFromUser($user, $value)
    {
        Resources::find($user->id, ['id', 'gold'])->decrement('gold', $value);
    }
}
