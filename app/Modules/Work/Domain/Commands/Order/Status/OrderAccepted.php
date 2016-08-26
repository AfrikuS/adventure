<?php

namespace App\Modules\Work\Domain\Commands\Order\Status;

class OrderAccepted
{
    public $order_id;

    /**
     * OrderAccepted constructor.
     * @param $order_id
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }
}
