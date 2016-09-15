<?php

namespace App\Modules\Work\Domain\Commands\Order\Builder;

class GenerateSkills
{
    public $order_id;
    public $needTimes;

    public function __construct($order_id, $needTimes)
    {
        $this->order_id = $order_id;
        $this->needTimes = $needTimes;
    }
}
