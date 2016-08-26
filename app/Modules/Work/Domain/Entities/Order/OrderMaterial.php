<?php

namespace App\Modules\Work\Domain\Entities\Order;

class OrderMaterial
{
    public $id;
    public $code;
    public $order_id;
    public $need;
    public $stock;

    public function __construct(\stdClass $orderMaterialsData)
    {
        $this->id = $orderMaterialsData->id;
        $this->order_id = $orderMaterialsData->order_id;
        $this->code = $orderMaterialsData->code;
        $this->need = $orderMaterialsData->need;
        $this->stock = $orderMaterialsData->stock;
    }
    
    public function stockAmount($amount)
    {
        $this->stock += $amount;
    }
}
