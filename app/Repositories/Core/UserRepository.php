<?php

namespace App\Repositories\Core;

use App\Models\Auth\User;

class UserRepository
{
    public function createUser(string $name, string $password, string $mail)
    {
        return User::create([
            'name' => $name,
            'email' => $name . '@mail.com',
            'password' => bcrypt($password),
        ]);
    }

}
