<?php

namespace App\Modules\Work\Domain\Commands\Order\Builder;

class CreateOrderData
{
    public $desc;
    public $domainCode;
    public $price;
    public $customer_id;

    public function __construct($desc, $domainCode, $price, $customer_id)
    {
        $this->desc = $desc;
        $this->domainCode = $domainCode;
        $this->price = $price;
        $this->customer_id = $customer_id;
    }
}
