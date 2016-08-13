<?php

namespace App\Persistence\Aggregates;

use App\Persistence\Dao\Work\WorkerDao;
use App\Persistence\Dao\Work\WorkerMaterialsDao;

class Worker
{

    public static function fromRepo($user_id)
    {
        $workerDao = new WorkerDao();
        $workerMaterialsDao = new WorkerMaterialsDao();
        
        $worker = $workerDao->findById($user_id);
        $materials = $workerMaterialsDao->getMaterials($worker->id);
        
        $materialsMap = [];
        
        foreach ($materials as $material) {
            $code = $material->code;
            $materialsMap[$code] = $material->value;
        }
        
        $worker->materials = $materialsMap;
    }
}
