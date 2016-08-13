<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\WorkerDao;
use App\Persistence\Dao\Work\WorkerMaterialsDao;
use App\Persistence\Models\Work\Order\Materials;
use App\Persistence\Models\Work\Worker;

class WorkerRepo
{
    /** @var WorkerMaterialsDao */
    private $materialsDao;

    /** @var  WorkerMaterialsRepo */
    private $materialsRepo;

    /** @var WorkerDao */
    private $workerDao;

    public function __construct()
    {
        $this->materialsDao = new WorkerMaterialsDao();
        $this->materialsRepo = new WorkerMaterialsRepo();
        $this->workerDao = new WorkerDao();
    }

    public function findWithMaterialsById($worker_id)
    {
        $workerData = $this->workerDao->findById($worker_id);

        $materials = $this->materialsDao->getMaterials($worker_id);

        $workerData->materials = $materials;


        return new Worker($workerData);
    }

    public function updateMaterialAmount(Worker $worker, $materialCode)
    {
        $material = $worker->materials->getByCode($materialCode);

        $this->materialsDao->save($material);
    }

    public function findSimpleWorker($worker_id)
    {
        $workerData = $this->workerDao->findById($worker_id);
        

        return new Worker($workerData);
    }

    public function getWithMaterialsByUser($user_id)
    {
//        $workerDao = new WorkerDao();
//        $workerMaterialsDao = new WorkerMaterialsDao();

        $worker = $this->workerDao->findById($user_id);
        $materials = $this->materialsDao->getMaterials($worker->id);

        $materialsMap = [];

        foreach ($materials as $material) {
            $code = $material->code;
            $materialsMap[$code] = $material;
        }

        $materials = new Materials($materialsMap, $user_id);


        $worker->materials = $materials;
        
        return new Worker($worker);
    }

    public function updateMaterials(Materials $materials)
    {
        $materialsArr = $materials->extract();
        
        foreach ($materialsArr as $material) {
            
            $this->materialsDao->save($material);
        }
    }

}
