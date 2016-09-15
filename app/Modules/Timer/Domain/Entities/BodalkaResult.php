<?php

namespace App\Modules\Timer\Domain\Entities;

class BodalkaResult
{
    public $user_id;
    public $endingAt;
    
    public $gold;
    public $oil;
    public $water;

    public function __construct($user_id, $endingAt, $gold, $oil, $water)
    {
        $this->user_id = $user_id;
        $this->endingAt = $endingAt;
        $this->gold = $gold;
        $this->oil = $oil;
        $this->water = $water;
    }

}
