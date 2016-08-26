<?php

namespace App\Modules\Work\Domain\Entities\Shop;

class ShopMaterial
{
    public $id;
    public $code;
    public $amount;
    public $price;

    public function __construct(\stdClass $shopMaterialData)
    {
        $this->id = $shopMaterialData->id;
        $this->code = $shopMaterialData->code;
        $this->amount = 60; //$shopMaterialData->amount;
        $this->price = $shopMaterialData->price;
    }
}
