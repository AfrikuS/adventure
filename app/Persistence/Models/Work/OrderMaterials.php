<?php

namespace App\Persistence\Models\Work;

use App\Exceptions\NotEnoughMaterialException;
use App\Persistence\Models\Work\Order\OrderMaterial;

class OrderMaterials
{
    private $materialsMap;

    public function __construct(array $materialsMap)
    {
        $this->materialsMap = $materialsMap;
    }

    public function getByCode($code)
    {
        if (! isset($this->materialsMap[$code])) {

            throw new NotEnoughMaterialException;
        }

        return $this->materialsMap[$code];
    }

    public function addMaterial($material)
    {
        if ($this->isExistMaterial($material)) {

            $this->materialsMap[$material->code]->value += $material->amount;
        }
        else {

            $this->materialsMap[$material->code] = $this->buildMaterial($material);
        }
    }

    private function isExistMaterial($material)
    {
        $code = $material->code;

        return isset($this->materialsMap[$code]);
    }

    public function buildMaterial($material)
    {
        $newMaterial = new \stdClass();
        $newMaterial->user_id = $this->worker_id;
        $newMaterial->code = $material->code;
        $newMaterial->value = $material->amount;


        return $newMaterial;
    }

    public function stockMaterial(OrderMaterial $material)
    {
        $amount = $material->need - $material->stock;

        $this->materialsMap[$material->code]->stock += $amount;
    }

    public function decrementMaterial(OrderMaterial $material)
    {
        $amount = $material->need - $material->stock;

        $this->materialsMap[$material->code]->value -= $amount;
    }

    public function extract()
    {
        return array_values($this->materialsMap);
    }

    public function selectIntersect(Materials $others)
    {
        $intersect = [];

        $codes = array_keys( $this->materialsMap );

        foreach ($others->extract() as $other) {

            if (in_array($other->code, $codes)) {
                $intersect[] = $other;
            }
        }

        return $intersect;
    }

}
