<?php

namespace App\Modules\Work\Persistence\Repositories\Worker;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Entities\Worker\Worker;
use App\Modules\Work\Persistence\Dao\Worker\WorkerDao;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;

class WorkerRepo
{
    /** @var  WorkerMaterialsRepo */
    private $materialsRepo;

    /** @var WorkerInstrumentsRepo */
    private $instrumentsRepo;

    /** @var WorkerDao */
    private $workerDao;
    
    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct(WorkerMaterialsRepo $materialsRepo, 
                                WorkerInstrumentsRepo $instrumentsRepo,
                                OrdersRepo $ordersRepo,
                                WorkerDao $workerDao
    )
    {
        $this->materialsRepo = $materialsRepo;
        $this->instrumentsRepo = $instrumentsRepo;
        $this->ordersRepo = $ordersRepo;
        $this->workerDao = $workerDao;
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

    
/*    public function getWithMaterialsByUser($user_id)
    {
        $worker = EntityStore::get(Worker::class, $user_id);

        if (null !== $worker) {
            return $worker;
        }

        $workerData = $this->workerDao->findById($user_id);

        $worker = new Worker($workerData);

        EntityStore::add($worker, $worker->id);



        $materials = $this->materialsRepo->getBy($worker->id);

        $materialsMap = [];

        foreach ($materials as $material) {

            $code = $material->code;
            $materialsMap[$code] = $material;
        }

        $worker->setMaterials($materialsMap);
        
        return $worker;
    }*/

    public function getNeedMaterialsForOrder($user_id, $order_id)
    {
        /** @var Order $order */
        $order = $this->ordersRepo->findOrderWithMaterialsById($order_id);
        
        $codes = $order->materials->getCodes();

        $workerNeedMaterials = $this->materialsRepo->getForOrder($user_id, $codes);

        return $workerNeedMaterials;
    }
}
