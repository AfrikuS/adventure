<?php

namespace App\Modules\Work\Domain\Entities\Order;

class OrderMaterialsCollection
{
    public $materials;

    public function __construct()
    {
        $this->materials = [];
    }

    public function addMaterial(OrderMaterial $material)
    {
        $this->materials[$material->id] = $material;
    }

    public function find($id)
    {
        return $this->materials[$id];
    }

    public function getIds()
    {
        return array_keys($this->materials);
    }
}
