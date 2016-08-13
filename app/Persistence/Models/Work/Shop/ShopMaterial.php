<?php

namespace App\Persistence\Models\Work\Shop;

class ShopMaterial
{
    public $code;
    public $amount;
    public $price;

    public function __construct($code, $amount, $price)
    {
        $this->code = $code;
        $this->amount = $amount;
        $this->price = $price;
    }
}
