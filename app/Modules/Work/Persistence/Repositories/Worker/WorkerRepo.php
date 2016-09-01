<?php

namespace App\Modules\Work\Persistence\Repositories\Worker;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Worker\Worker;
use App\Modules\Work\Persistence\Dao\Worker\WorkerDao;
use App\Modules\Work\Persistence\Dao\Worker\WorkerMaterialsDao;

class WorkerRepo
{
    /** @var WorkerMaterialsDao */
    private $materialsDao;

    /** @var  WorkerMaterialsRepo */
    private $materialsRepo;

    /** @var WorkerInstrumentsRepo */
    private $instrumentsRepo;

    /** @var WorkerDao */
    private $workerDao;

    public function __construct()
    {
        $this->materialsDao = app('WorkerMaterialsDao');
        $this->materialsRepo = app('WorkerMaterialsRepo');
        $this->instrumentsRepo = app('WorkerInstrumentsRepo');
        $this->workerDao = app('WorkerDao');
    }

    public function getMaterials($worker_id)
    {
        $materials = $this->materialsRepo->getBy($worker_id);

        return $materials;
    }

    public function getInstruments($worker_id)
    {
        $instruments = $this->instrumentsRepo->getBy($worker_id);

        return $instruments;
    }


    /** @deprecated */
    public function updateMaterialAmount(Worker $worker, $materialCode)
    {
        $material = $worker->materials->getByCode($materialCode);

        $this->materialsDao->save($material);
    }

    public function findSimpleWorker($worker_id)
    {
        $worker = EntityStore::get(Worker::class, $worker_id);

        if (null !== $worker) {
            return $worker;
        }

        $workerData = $this->workerDao->findById($worker_id);

        $worker = new Worker($workerData);

        EntityStore::add($worker, $worker->id);

        return $worker;
    }

    public function getWithMaterialsByUser($user_id)
    {
        $worker = EntityStore::get(Worker::class, $user_id);

        if (null !== $worker) {
            return $worker;
        }

        $workerData = $this->workerDao->findById($user_id);

        $worker = new Worker($workerData);

        EntityStore::add($worker, $worker->id);



        $materials = $this->materialsDao->getMaterials($worker->id);

        $materialsMap = [];

        foreach ($materials as $material) {

            $code = $material->code;
            $materialsMap[$code] = $material;
        }

//        $materials = new Materials($materialsMap, $user_id);


        $worker->setMaterials($materialsMap);
        
        return $worker;
    }

/*    public function updateMaterials(Materials $materials)
    {
        $materialsArr = $materials->extract();
        
        foreach ($materialsArr as $material) {
            
            $this->materialsDao->save($material);
        }
    }*/

    public function getWorkerMaterialsByOrder($order_id)
    {
        $orderMaterials_ids = 34;

//        order_materials_ids

//        intersect_ids (order_materials & worker_materials)
    }
}
