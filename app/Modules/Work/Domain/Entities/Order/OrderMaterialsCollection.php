<?php

namespace App\Modules\Work\Domain\Entities\Order;

class OrderMaterialsCollection
{
    public $materials;

    public function __construct()
    {
        $this->materials = [];
    }

    public function add(OrderMaterial $material)
    {
        $this->materials[$material->code] = $material;
    }

    public function getBy($code): OrderMaterial
    {
        return $this->materials[$code];
    }

    public function getCodes()
    {
        return array_keys($this->materials);
    }

    public function isStockCompleted()
    {
        $needSum = array_reduce($this->materials, function ($sum, OrderMaterial $material) {
            return $sum += $material->need;
        }, 0);
        
        $stockSum = array_reduce($this->materials, function ($sum, OrderMaterial $material) {
            return $sum += $material->stock;
        }, 0);
        
        return $stockSum >= $needSum;
    }

    public function getRemainMaterialAmount($materialCode)
    {
        /** @var OrderMaterial $material */
        $material = $this->materials[$materialCode];

        $remainAmount = $material->need - $material->stock;

        return $remainAmount;
    }
}
