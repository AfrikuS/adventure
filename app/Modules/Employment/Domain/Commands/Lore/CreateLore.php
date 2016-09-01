<?php

namespace App\Modules\Employment\Domain\Commands\Lore;

class CreateLore
{
    public $user_id;
    
    public $domain_id;
    
    public function __construct($user_id, $domain_id)
    {
        $this->user_id = $user_id;

        $this->domain_id = $domain_id;
    }
}
