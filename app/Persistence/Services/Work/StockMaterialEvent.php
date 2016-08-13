<?php

namespace App\Persistence\Services\Work;

use App\Persistence\Models\Work\Order\OrderMaterial;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;

class StockMaterialEvent
{
    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct(OrderMaterialsRepo $orderMaterialsRepo)
    {
        $this->orderMaterialsRepo = $orderMaterialsRepo;
    }

    public function handle($order_id, $code, $amount)
    {
        /** @var OrderMaterial $material */
        $material = $this->orderMaterialsRepo->findBy($order_id, $code);

        // method on null object except

        $this->handleMaterial($material, $amount);
    }

    public function handleMaterial(OrderMaterial $material, $amount)
    {
        $material->stockAmount($amount);

        $this->orderMaterialsRepo->update($material);
    }

}
