<?php

namespace App\Operations\Work\Order;

use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\WorkerMaterialsRepo;

class AddMissingMaterialsToWorker
{
    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct()
    {
        $this->orderMaterialsRepo = new OrderMaterialsRepo();
        $this->workerMaterialsRepo = new WorkerMaterialsRepo();
    }

    public function includeMissingMaterials($worker, $order)
    {
        $orderMaterialsCodes = $this->orderMaterialsRepo->getCodesByOrderId($order->id);
        
        $workerMaterialsCodes = $this->workerMaterialsRepo->getCodesByWorkerId($worker->id);
        
        
        
        $missingMaterialCodes = $this->selectMissingMaterialCodes($orderMaterialsCodes, $workerMaterialsCodes);

        if (count($missingMaterialCodes) > 0) {
            $this->createMissingMaterials($worker, $missingMaterialCodes);
        }


    }

    private function createMissingMaterials($worker, $codes)
    {
        foreach ($codes as $code) 
        {
            $material = $this->workerMaterialsRepo->createMaterial($code, $worker->id);
            
            $this->workerMaterialsRepo->save($material);
        }
        
/*        $codes->each(function ($code, $key) use ($worker) {

            WorkerFactory::createWorkerMaterial($worker, $code);
        });*/
    }


    private function selectMissingMaterialCodes($orderCodes, $workerMaterialCodes)
    {
        
        $missingCodes = array_filter($orderCodes, function ($code) use ($workerMaterialCodes) {
            return ! in_array($code, $workerMaterialCodes);
        });

//        $missingCodes = $order->materials->reject(function ($material) use ($workerMaterialCodes) {
//            return in_array($material->code,  $workerMaterialCodes);
//        })->pluck('code');

        return $missingCodes;
    }


}
