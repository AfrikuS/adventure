<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\WorkerDao;
use App\Persistence\Dao\Work\WorkerMaterialsDao;
use App\Persistence\Models\Work\Worker;

class WorkerRepo
{
    /** @var WorkerMaterialsDao */
    private $materialsDao;

    /** @var WorkerDao */
    private $workerDao;

    public function __construct()
    {
        $this->materialsDao = new WorkerMaterialsDao();
        $this->workerDao = new WorkerDao();
    }

    public function findWithMaterialsById($worker_id)
    {
        $workerModel = $this->workerDao->findById($worker_id);

        $materials = $this->materialsDao->getMaterials($worker_id);

        $workerModel->materials = $materials;


        return new Worker($workerModel);
    }

    public function updateMaterialAmount(Worker $worker, $materialCode)
    {
        $material = $worker->findMaterialByCode($materialCode);

        $this->materialsDao->save($material);
    }

}
