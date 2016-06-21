<?php

namespace App\Repositories;

use App\Models\HeroResources;
use App\Models\User;

class HeroResourcesRepository
{
    public static function transferGoldBetweenUsers($fromUser_id, $toUser_id, $count)
    {
        $fromUser = HeroResources::find($fromUser_id);
        $toUser = HeroResources::find($toUser_id);

        $fromUser->gold -= $count;
        $toUser->gold += $count;

        $fromUser->save();
        $toUser->save();
    }

    public static function addGoldToUser($user, $value)
    {
        HeroResources::find($user->id)->increment('gold', $value);
//        $user->increment('gold', $value);
//        $user->gold += $goldValue;
//        $user->save();
    }

    public static function subtractGoldFromUser($user, $value)
    {
        HeroResources::find($user->id, ['id', 'gold'])->decrement('gold', $value);
//        $resources->decrement('gold', $value);
    }
}
