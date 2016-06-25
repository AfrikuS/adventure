<?php

namespace App\Repositories;

use App\Models\Hero\Thing;

class HeroRepository
{
    public static function getHeroThings($user)
    {
        return Thing::select('id', 'title', 'status')->where('owner_id', $user->id)->get();

    }

    public static function findHeroThingById($id)
    {
        return Thing::find($id, ['id', 'title', 'status']);
    }
}
