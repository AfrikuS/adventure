<?php

namespace App\Modules\Work\Commands\Order;

use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Repositories\Work\OrderRepositoryObj;

class CreateBuildOrderAction
{
    /** @var OrdersRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrdersRepo');
    }

    public function createBuildOrder(int $customer_id)
    {
        $orderBuilderService = new OrderBuilderService();
        
        \DB::beginTransaction();
        try {


            $orderBuilderService->generateOrderData($customer_id);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }
}
