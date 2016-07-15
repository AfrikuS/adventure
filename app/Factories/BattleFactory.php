<?php

namespace App\Factories;

use App\Models\Battle\Boss;
use App\Models\Battle\ResourceChannel;
use App\Repositories\Battle\BossRepository;
use App\Repositories\Battle\BossTimerRepository;

class BattleFactory
{
    public static function createBoss($author)
    {
        \DB::transaction(function () use ($author) {
            $boss = Boss::create([
                'user_id' => $author->id,
                'users_count' => 1,
            ]);

            $boss->users()->save($author);
            
            BossTimerRepository::createTimer($boss->id);
        });
    }

    public static function createResourceChannel($atacker_id, $victim_id)
    {
        ResourceChannel::create([
            'to_user_id' => $atacker_id,
            'from_user_id' => $victim_id,
            'resource' => 'gold',
            'tax_percent' => 3,
        ]);
    }
}
