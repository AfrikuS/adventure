<?php

namespace App\Persistence\Models\Work;

use App\Exceptions\NotEnoughMaterialException;
use App\Persistence\Models\DataObject;

class Worker extends DataObject
{
    /** @deprecated  */
    public function addMaterials($materials)
    {
        foreach ($materials as $material)
        {
            
        }
    }

    /** @deprecated  */
    public function addMaterial($material)
    {
        
    }

    public function includeMaterials($materials)
    {
        foreach ($materials as $material) {

            $newMaterial = new \stdClass();
            $newMaterial->user_id = $this->id;
            $newMaterial->code = $material->code;
            $newMaterial->value = 0;

            $this->dataObject->materials[$material->code] = $newMaterial;
        }
    }

    protected function getAttributes()
    {
        return ['id', 'team_id', 'status',

                'materials', 'hero'];
    }

    public function decrementMaterial($material)
    {
//        $material = $this->findMaterialByCode($code);

        $workerMaterial = $this->materials->getByCode($material->code);


        $stockAmount = $material->need - $material->stock;

        if ($workerMaterial->value < $stockAmount) {
            throw new NotEnoughMaterialException;
        }

        $this->materials->decrementMaterial($material);
//        // redo
//        $workerMaterial->value -= $stockAmount;
//
//        $stockMaterial = new \stdClass();
//        $stockMaterial->code = $material->code;
//        $stockMaterial->amount = $stockAmount;
//
//        return $stockMaterial;
    }

    public function findMaterialByCode($code)
    {
        $material = array_filter($this->materials, function ($material) use ($code) {
            return $material->code === $code;
        });

        return array_pop($material);
    }
    
    

}
