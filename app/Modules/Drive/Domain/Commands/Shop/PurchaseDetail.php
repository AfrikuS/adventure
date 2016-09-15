<?php

namespace App\Modules\Drive\Domain\Commands\Shop;

class PurchaseDetail
{
    public $offer_id;
    
    public $driver_id;

    public function __construct($offer_id, $driver_id)
    {
        $this->offer_id = $offer_id;
        $this->driver_id = $driver_id;
    }
}
