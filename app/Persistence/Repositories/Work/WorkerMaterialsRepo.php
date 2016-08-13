<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\OrderMaterialsDao;
use App\Persistence\Dao\Work\WorkerMaterialsDao;
use App\Persistence\Models\Work\Order\WorkerMaterial;

class WorkerMaterialsRepo
{
    /** @var WorkerMaterialsDao */
    private $materialsDao;

    public function __construct()
    {
        $this->materialsDao = new WorkerMaterialsDao();
    }

/*    public function getCodes()
    {
//        $materialsCodes = Material::get(['id', 'code'])->pluck('code');
        
        $codes = $this->materialsDao->getCodes();
        
        $codesArr = array_map(function ($codeObj) {
            return $codeObj->code;
        }, $codes);

        return $codesArr;
    }*/

    public function createMaterial($code, $worker_id)
    {
        $material = new \stdClass();
        
        $material->code = $code;
        $material->worker_id = $worker_id;
        $material->value = 0;
        
        return $material;
    }

    public function save($material)
    {
        $this->materialsDao->save($material);
    }

    public function update($material)
    {
        $this->materialsDao->update($material);
    }

    public function getCodesByWorkerId($worker_id)
    {
        $materials = $this->materialsDao->getMaterials($worker_id);

        $codesArr = array_map(function ($material) {
            return $material->code;
        }, $materials);

        return $codesArr;
    }

    /** @deprecated  */
    public function updateMaterials($worker)
    {
//        $worker_id = $materials->worker
        $materialsArr = $worker->materials->extractMeterials();
            
        foreach ($materialsArr as $material) {
            
            $this->materialsDao->save($material);
        }
        
    }

    public function findBy($worker_id, $code) 
    {
        $materialData = $this->materialsDao->find($worker_id, $code);

        if (null == $materialData) {
            return null;
        }
        
        return new WorkerMaterial($materialData, $this);
    }

    public function create($user_id, $code, $amount)
    {
        $material = new \stdClass();
        $material->user_id = $user_id;
        $material->code = $code;
        $material->value = $amount;
        
        $this->materialsDao->save($material);
    }
}
