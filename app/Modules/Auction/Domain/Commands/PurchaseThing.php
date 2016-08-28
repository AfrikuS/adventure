<?php

namespace App\Modules\Auction\Domain\Commands;

class PurchaseThing
{
    public $thing_id;
    public $purchaser_id;

    public function __construct($thing_id, $purchaser_id)
    {
        $this->thing_id = $thing_id;
        $this->purchaser_id = $purchaser_id;
    }
}
