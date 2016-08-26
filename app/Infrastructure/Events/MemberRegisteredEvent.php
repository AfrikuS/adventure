<?php

namespace App\Infrastructure\Events;

class MemberRegisteredEvent
{
    public $member;
    
    public function __construct(Member $member) 
    { 
        $this->member = $member; 
    } 
} 

