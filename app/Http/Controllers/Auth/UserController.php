<?php

namespace App\Http\Controllers\Auth;

use App\Domain\UserActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Resources;
use App\Models\User;
use App\Models\UserRedis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('sign_in_page');
    }


    public function register(RegisterUserRequest $request)
    {
        $data = $request->all();
        $user = UserActions::createNewUser($data);

        Auth::login($user);
        UserRedis::loginUser($user);

        return redirect()->route('index_page');
    }

 }