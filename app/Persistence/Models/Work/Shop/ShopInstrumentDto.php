<?php

namespace App\Persistence\Models\Work\Shop;

class ShopInstrumentDto
{
    public $code;
    public $charge;
    public $price;

    public function __construct($code, $charge, $price)
    {
        $this->code = $code;
        $this->charge = $charge;
        $this->price = $price;
    }
}
