<?php

namespace App\Modules\Work\Domain\Handlers\Order;


use App\Modules\Work\Domain\Commands\Order\StockMaterial;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;

class StockMaterialHandler
{
    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct()
    {
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
    }

//    public function handle($order_id, $code, $amount)
//    {
//        /** @var OrderMaterial $material */
//        $material = $this->orderMaterialsRepo->findBy($order_id, $code);
//
//        // method on null object except
//
//        $this->handleMaterial($material, $amount);
//    }

    public function handle(StockMaterial $command)
    {
        $command->orderMaterial->stockAmount($command->amount);

        $this->orderMaterialsRepo->update($command->orderMaterial);
    }

}
