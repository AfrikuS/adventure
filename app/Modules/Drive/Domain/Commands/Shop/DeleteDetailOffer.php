<?php

namespace App\Modules\Drive\Domain\Commands\Shop;

class DeleteDetailOffer
{
    public $offer_id;
    
    public function __construct($offer_id)
    {
        $this->offer_id = $offer_id;
    }
}
