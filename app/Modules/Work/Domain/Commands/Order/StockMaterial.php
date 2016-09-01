<?php

namespace App\Modules\Work\Domain\Commands\Order;

class StockMaterial
{
    public $order_id;
    
    public $materialCode;
    
    public $amount;

    public function __construct($order_id, $materialCode, $amount)
    {
        $this->order_id = $order_id;
        $this->materialCode = $materialCode;
        $this->amount = $amount;
    }
}
