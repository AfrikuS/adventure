<?php

namespace App\Modules\Work\Domain\Commands\Order\Builder;

class CreateOrderData
{
    public $desc;
    public $domain_id;
    public $price;
    public $customer_id;

    public function __construct($desc, $domain_id, $price, $customer_id)
    {
        $this->desc = $desc;
        $this->domain_id = $domain_id;
        $this->price = $price;
        $this->customer_id = $customer_id;
    }
}
