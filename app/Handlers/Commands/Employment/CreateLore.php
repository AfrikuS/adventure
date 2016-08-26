<?php

namespace App\Handlers\Commands\Employment;

class CreateLore
{
    public $user_id;
    
    /** @var string */
    public $domainCode;
    
    public function __construct($user_id, $domainCode)
    {
        $this->user_id = $user_id;

        $this->domainCode = $domainCode;
    }
}
