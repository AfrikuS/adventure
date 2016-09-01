<?php

namespace App\Modules\Work\Domain\Commands\Order\Status;

class OrderCompleted
{
    public $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }
}
