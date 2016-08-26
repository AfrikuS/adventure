<?php

namespace App\Modules\Work\Domain\Entities\Worker;

class Worker
{
    public $id;
    public $team_id;
    public $status;

//    public $materials;

    public function __construct(\stdClass $workerData)
    {
        $this->id = $workerData->id;
        $this->team_id = $workerData->team_id;
        $this->status = $workerData->status;

        $this->materials = null;
    }

/*    public function setMaterials(Materials $materials)
    {
        $this->materials = $materials;
    }*/


//    public function includeMaterials($materials)
//    {
//        foreach ($materials as $material) {
//
//            $newMaterial = new \stdClass();
//            $newMaterial->user_id = $this->id;
//            $newMaterial->code = $material->code;
//            $newMaterial->value = 0;
//
//            $this->dataObject->materials[$material->code] = $newMaterial;
//        }
//    }

/*    public function decrementMaterial($material)
    {
//        $material = $this->findMaterialByCode($code);

        $workerMaterial = $this->materials->getByCode($material->code);


        $stockAmount = $material->need - $material->stock;

        if ($workerMaterial->value < $stockAmount) {
            throw new NotEnoughMaterialException;
        }

        $this->materials->decrementMaterial($material);*/
//        // redo
//        $workerMaterial->value -= $stockAmount;
//
//        $stockMaterial = new \stdClass();
//        $stockMaterial->code = $material->code;
//        $stockMaterial->amount = $stockAmount;
//
//        return $stockMaterial;
//    }

/*    public function findMaterialByCode($code)
    {
        $material = array_filter($this->materials, function ($material) use ($code) {
            return $material->code === $code;
        });

        return array_pop($material);
    }*/
    
    

}
