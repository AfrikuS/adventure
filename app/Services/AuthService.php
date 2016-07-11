<?php

namespace App\Services;

use App\Models\Auth\User;
use App\Models\Auth\UserRedis;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function loginUser(User $user)
    {
        Auth::login($user);
        UserRedis::save($user);
    }

    public function logoutUser()
    {
        Auth::logout();
    }
}
