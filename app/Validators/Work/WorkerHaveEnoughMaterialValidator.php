<?php

namespace Validators\Work;

class WorkerHaveEnoughMaterialValidator
{

    public function isWorkerHaveEnoughMaterial($worker_id, $order_id, $materialCode)
    {
        $orderMaterial = $order->getMaterialByCode($materialCode);
        $workerMaterial = $worker->getMaterialByCode($materialCode);

        if ($workerMaterial === null) {
            WorkFactory::createWorkerMaterial($worker, $materialCode);
            return false;
        }

        $needAmount = $orderMaterial->need - $orderMaterial->stock;
        return $needAmount <= $workerMaterial->value;

    }
}
