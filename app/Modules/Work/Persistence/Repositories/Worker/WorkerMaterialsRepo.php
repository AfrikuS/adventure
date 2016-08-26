<?php

namespace App\Modules\Work\Persistence\Repositories\Worker;

use App\Modules\Work\Domain\Entities\Worker\WorkerMaterial;
use App\Modules\Work\Persistence\Dao\Worker\WorkerMaterialsDao;

class WorkerMaterialsRepo
{
    /** @var WorkerMaterialsDao */
    private $materialsDao;

    public function __construct()
    {
        $this->materialsDao = app('WorkerMaterialsDao');
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

    /** @deprecated */
    public function save($material)
    {
        $this->materialsDao->update(
            $material->id,
            $material->value
        );
    }

    public function update($material)
    {
        $this->materialsDao->update(
            $material->id,
            $material->value
        );
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
            
            $this->materialsDao->update($material->id, $material->value);
        }
        
    }

    public function getBy($worker_id)
    {
        $materialsData = $this->materialsDao->getMaterials($worker_id);
        
        return $materialsData;
    }

    public function findBy($worker_id, $code) 
    {
        $materialData = $this->materialsDao->find($worker_id, $code);

        if (null == $materialData) {
            return null;
        }
        
        return new WorkerMaterial($materialData);
    }

    public function create($user_id, $code, $amount)
    {
        $this->materialsDao->create($user_id, $code, $amount);
    }
}
