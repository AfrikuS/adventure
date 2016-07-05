<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRedis;
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
