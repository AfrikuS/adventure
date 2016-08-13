<?php

namespace App\Persistence\Models\Work\Order;

use App\Exceptions\NotEnoughMaterialException;

class Materials
{
    private $materialsMap;
    private $worker_id;

    public function __construct(array $materials, $worker_id)
    {
        $this->materialsMap = $materials;

        $this->worker_id = $worker_id;

//        $materials = $this->materialsDao->getOrderMaterialsById($order->id);


/*        foreach ($materials as $material) {
            
            $code = $material->code;
            
            $material = static::buildMaterial($material);

            $this->materialsMap[$code] = $material;
        }*/

//        $order->materials = $materialsMap;
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

    public function stockMaterial($orderMaterial)
    {
        $amount = $orderMaterial->need - $orderMaterial->stock;

        $this->materialsMap[$orderMaterial->code]->stock += $amount;
    }

    public function decrementMaterial($orderMaterial)
    {
        $amount = $orderMaterial->need - $orderMaterial->stock;

        $this->materialsMap[$orderMaterial->code]->value -= $amount;
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
