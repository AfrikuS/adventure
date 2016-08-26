<?php

namespace App\Modules\Work\Domain\Commands\Order;

use App\Modules\Work\Domain\Entities\Order\OrderMaterial;

class StockMaterial
{
    /** @var OrderMaterial */
    public $orderMaterial;
    
    public $amount;

    public function __construct(OrderMaterial $orderMaterial, $amount)
    {
        $this->orderMaterial = $orderMaterial;
        $this->amount = $amount;
    }
}
