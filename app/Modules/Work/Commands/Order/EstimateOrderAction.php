<?php

namespace App\Modules\Work\Commands\Order;

use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Domain\Services\Order\OrderService;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use Finite\Exception\StateException;

class EstimateOrderAction
{
    /** @var OrdersRepo */
    private $orderRepo;
    
    /** @var MaterialsRepo */
    private $materialsRepo;

    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct()
    {
        $this->materialsRepo = app('CatalogMaterialsRepo');
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
        $this->orderRepo = app('OrdersRepo');

    }

    public function estimateOrder($order_id)
    {
        $this->validateCommand($order_id);

        $orderBuilderService = new OrderBuilderService();

        /** @var OrderService $orderService */
        $orderService = app('OrderService');
        




        \DB::beginTransaction();
        try {

            $orderBuilderService->generateMaterials($order_id, 3);
            
            $orderBuilderService->generateSkill($order_id, 3);

            
            $orderService->estimate($order_id);

        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }
        \DB::commit();
    }

    private function validateCommand($order_id)
    {
        $order = $this->orderRepo->find($order_id);

        if ($order->status != Order::STATUS_ACCEPTED) {

            throw new StateException;
        }
    }
}
