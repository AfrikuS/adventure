<?php

namespace App\Modules\Work\Domain\Commands\Order;

class DeleteOrder
{
    public $order_id;

    /**
     * DeleteOrder constructor.
     * @param $order_id
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

}
