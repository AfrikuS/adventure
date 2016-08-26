<?php

namespace App\Modules\Work\Commands\Order;

use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Modules\Work\Domain\Services\Order\OrderBuilderService;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Repositories\Work\OrderRepositoryObj;

class CreateBuildOrderCommand
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }

    public function createBuildOrder(int $customer_id, string $type, int $reward)
    {
        $orderBuilderService = new OrderBuilderService();
        
        \DB::beginTransaction();
        try {

//            $desc = $type;
//            $price = $reward;
//            $skill = Skill::get()->random();

//            $this->orderRepo->createOrderModel($desc, $skill->code, $price, $customer_id);

            $orderBuilderService->generateOrderData($customer_id);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }
}
