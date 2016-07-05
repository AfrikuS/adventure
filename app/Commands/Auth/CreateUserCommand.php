<?php

namespace App\Commands\Auth;

use App\Factories\AppFactory;
use App\Factories\Macro\MacroFactory;

class CreateUserCommand
{
    /** @var CreateUserContext  */
    private $context;

    public function __construct(CreateUserContext $context)
    {
        $this->context = $context;
    }

    public function createUser()
    {
        $context = $this->context;
        
        return \DB::transaction(function () use ($context) {
            
            $user = AppFactory::createUser($context->name, $context->password, $context->email);

            AppFactory::createHero($user->id);
            MacroFactory::createPolitic($user->id);

            return $user;
        });
    }
}
