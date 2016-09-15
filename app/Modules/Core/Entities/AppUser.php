<?php

namespace App\Modules\Core\Entities;

class AppUser
{
    public $id;
    public $name;

    public function __construct(\stdClass $userData)
    {
        $this->id = $userData->id;
        $this->name = $userData->name;
    }
}
