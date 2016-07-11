<?php

namespace App\Http\Controllers\NotAuth;

use App\Http\Requests\LoginUserRequest;
use App\Models\Auth\UserRedis;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GuestController extends Controller
{
    use ValidatesRequests;

    public function signIn()
    {
        return view('user/sign_in', []);
    }

    public function signUp()
    {
        return view('user/sign_up', []);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->all();

        $credentials = [
            'name' => $data['name'],
//            'password' => '123',
        ];

        if (Auth::attempt($credentials, true)) {
            UserRedis::save($credentials);
            return \Redirect::route('profile_page');
        }

        Session::flash('message', 'Login ' . $data['name'] . ' is not correct');

        return redirect('/sign_in');
    }

}
