<?php

namespace App\Persistence\Models\Work;

use App\Persistence\Models\Hero;
use App\Persistence\Models\Work\Order\Materials;
use App\Persistence\Models\Work\Shop\ShopMaterial;

class Shop
{
    /** @var Materials */
    private $materials;

    /**
     * Shop constructor.
     * @param Materials $materials
     */
    public function __construct(Materials $materials)
    {
        $this->materials = $materials;
    }

    public function purchaseMaterial($shopMaterial, $worker, Hero $hero)
    {
//        $materialPayment = new MaterialPurchase();
//        $materialPayment->payment($worker, $shopMaterial);


        $hero->decrementGold($shopMaterial->price);

        $worker->materials->addMaterial($shopMaterial);
    }

    public function getPurchaseMaterialByCode($code, $amount)
    {
        $material = $this->materials->getByCode($code);

        $priceSum = $this->calculateSum($material, $amount);

        $shopMaterial = new ShopMaterial(
            $material->code,
            $amount,
            $priceSum
        );

        return $shopMaterial;
    }

    private function calculateSum($material, $amount)
    {
//        $priceSum = $material->price * $amount;
        return $material->price;

//        return $priceSum;
    }
}
