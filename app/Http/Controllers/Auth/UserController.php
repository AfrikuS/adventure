<?php

namespace App\Http\Controllers\Auth;

use App\Commands\Auth\CreateUserCommand;
use App\Commands\Auth\CreateUserContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;

class UserController extends Controller
{
    /** @var AuthService  */
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
        
        parent::__construct();
    }

    public function logout()
    {
        $this->authService->logoutUser();
        
        return redirect()->route('sign_in_page');
    }


    public function register(RegisterUserRequest $request)
    {
        $data = $request->all();
     
        $context = new CreateUserContext($data['name'], $data['password'], $data['email']);
        $command = new CreateUserCommand($context);
        $user = $command->createUser();

        $this->authService->loginUser($user);

        return redirect()->route('index_page');
    }

 }