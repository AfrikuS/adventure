<?php

namespace App\Commands\Auth;

use App\Factories\AppFactory;
use App\Factories\Macro\MacroFactory;
use App\Models\Auth\User;
use App\Repositories\Core\UserRepository;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Macro\ResourcesRepository;

class CreateUserCommand
{
    /** @var UserRepository */
    private $userRepo;
    /** @var  HeroRepositoryObj */
    private $heroRepo;

    public function __construct(UserRepository $userRepo, HeroRepositoryObj $heroRepo)
    {
        $this->userRepo = $userRepo;
        $this->heroRepo = $heroRepo;
    }

    public function createUser(array $data): User
    {

        \DB::beginTransaction();
        try {
            $user = $this->userRepo->createUser($data['name'], $data['password'], $data['email']);

            $this->heroRepo->createHero($user->id);
            
            ResourcesRepository::createPolitic($user->id);
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw  $e;
        }
        
        \DB::commit();
        
        return $user;
    }
}
