<?php

namespace App\Persistence\Models\Work\Order;

use App\Persistence\Models\DataObject;

class OrderMaterial extends DataObject
{
    protected function getAttributes()
    {
        return ['id', 'order_id', 'code', 'need', 'stock'];
    }


    public function stockAmount($amount)
    {
        $this->dataObject->stock += $amount;
    }




}
