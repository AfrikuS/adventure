<?php

namespace App\Modules\Work\Domain\Commands\Order\Status;

use App\Persistence\Models\Work\Order;

class OrderStockedMaterials
{
    public $order_id;

    /**
     * OrderStockedMaterials constructor.
     * @param $order
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }
}
