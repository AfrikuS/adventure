<?php

namespace App\Factories;

use App\Models\Core\Hero;
use App\Models\User;

class AppFactory
{
    public static function createUser(string $name, string $password, string $mail)
    {
        return User::create([
            'name' => $name,
            'email' => $name . '@mail.com',
            'password' => bcrypt($password),
        ]);
    }

    public static function createHero($user_id)
    {
        // default data for hero
        return Hero::create([
            'id' => $user_id,
            'gold'  => 500,
            'oil'   => 600,
            'water' => 700,
        ]);
    }
}
