<?php

namespace App\Modules\Work\Domain\Entities\Shop;

class ShopInstrument
{
    public $id;
    public $code;
    public $charge;
    public $price;

    public function __construct(\stdClass $shopInstrumentData)
    {
        $this->id = $shopInstrumentData->id;
        $this->code = $shopInstrumentData->code;
        $this->charge = 60;// $shopInstrumentData->charge;
        $this->price = $shopInstrumentData->price;
    }
}
