<?php

namespace App\ViewModel;

use App\Models\Work\Order;
use App\Models\Work\Worker;

class WorkViewModels
{
    public static function getWorkerMaterialsNeedForOrder(Order $order, Worker $worker)
    {
        $orderMaterials = $order->materials;
        $workerMaterials = $worker->materials;

        $needMaterialsCodes = $orderMaterials->map(function ($material, $key) {
            return $material->code;
        })->toArray();

        if (count($needMaterialsCodes) > 0) {
            return $workerMaterials->filter(function ($material) use ($needMaterialsCodes) {
                return in_array($material->code, $needMaterialsCodes);
            });
        }

        return [];
    }
}
