<?php

namespace App\Persistence\Models\Work\Order;

class Material
{
    public $code;
    public $need;
    public $stock;

    public function __construct($code, $need, $stock)
    {
        $this->code = $code;
        $this->need = $need;
        $this->stock = $stock;
    }

}
