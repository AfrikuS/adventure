<?php

namespace App\Commands\Auth;

use App\Commands\CommandContext;

class CreateUserContext extends CommandContext
{
    private $name;
    private $password;
    private $email;

    /**
     * CreateUserContext constructor.
     * @param $email
     * @param $name
     * @param $password
     */
    public function __construct(string $name, string $password, string $email)
    {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
    }
}
