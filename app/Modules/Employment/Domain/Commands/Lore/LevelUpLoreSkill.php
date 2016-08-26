<?php

namespace App\Modules\Employment\Domain\Commands\Lore;

class LevelUpLoreSkill
{
    /** @var string */
    public $domainCode;
    
    /** @var int */
    public $user_id;
    
    /** @var int */
    public $skillIndex;

    public function __construct(string $domainCode, int $user_id, int $skillIndex)
    {
        $this->domainCode = $domainCode;
        
        $this->user_id = $user_id;
        
        $this->skillIndex = $skillIndex;
    }
}
