<?php

namespace App\Repositories;

use App\Models\HeroThing;

class HeroRepository
{
    public static function getHeroThings($user)
    {
        return HeroThing::select('id', 'title', 'status')->where('owner_id', $user->id)->get();

    }

    public static function findHeroThingById($id)
    {
        return HeroThing::find($id, ['id', 'title', 'status']);
    }
}
