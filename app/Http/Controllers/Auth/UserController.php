<?php

namespace App\Http\Controllers\Auth;

use App\Commands\Application\CreateAccountCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\Core\UserRepository;
use App\Repositories\HeroRepositoryObj;
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
     
        $command = new CreateAccountCommand(new UserRepository(), new HeroRepositoryObj());
        
        $user = $command->createAccount($data);

        $this->authService->loginUser($user);

        return redirect()->route('index_page');
    }

 }