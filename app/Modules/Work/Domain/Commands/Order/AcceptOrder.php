<?php

namespace App\Modules\Work\Domain\Commands\Order;

class AcceptOrder
{
    public $order_id;
    
    public $worker_id;

    /**
     * AcceptOrder constructor.
     * @param $order_id
     * @param $worker_id
     */
    public function __construct($order_id, $worker_id)
    {
        $this->order_id = $order_id;
        $this->worker_id = $worker_id;
    }
}
