<?php

namespace App\Persistence\Services\Work\Order;

class OrderDataDto
{
    public $desc;
    public $skillCode;
    public $price;
    public $customer_id;

    public function __construct($desc, $skillCode, $price, $customer_id)
    {
        $this->desc = $desc;
        $this->skillCode = $skillCode;
        $this->price = $price;
        $this->customer_id = $customer_id;
    }
}
