<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;

class GenerateOrderAction
{
    /** @var OrdersRepo */
    private $ordersRepo;

    /** @var MaterialsRepo */
    private $materialsRepo;

    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct()
    {
        $this->materialsRepo = app('CatalogMaterialsRepo');
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
        $this->ordersRepo = app('OrdersRepo');
    }

    public function generateOrder($worker_id)
    {
        $orderBuilderService = new OrderBuilderService(
            $this->materialsRepo,
            $this->orderMaterialsRepo
        );


        \DB::beginTransaction();
        try {


            $orderBuilderService->generateOrderData($worker_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }
}
