<?php

namespace App\Domain;

use App\Models\HeroResources;
use App\Models\Macro\Resources;
use App\Models\User;
use DB;

class UserActions
{
    public static function createNewUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['name'] . '@mail.com',
            'password' => bcrypt($data['password']),
        ]);

        DB::transaction(function () use ($user) {
            HeroResources::create(['id' => $user->id]);
            Resources::create([
                'id' => $user->id,
                'food' => 5000,
                'tree' => 9000,
                'water' => 4000,
                'free_people' => 700,
            ]);
        });

        return $user;
    }
}
