<?php

namespace App\Commands\Work\IndividualOrder;

use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Repositories\Work\OrderRepositoryObj;

class CreateBuildOrderCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;

    public function __construct(OrderRepositoryObj $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function createBuildOrder(int $customer_id, string $type, int $reward)
    {

        \DB::beginTransaction();
        try {

            $desc = $type;
            $price = $reward;
            $skill = Skill::get()->random();

            $this->orderRepo->createOrderModel($desc, $skill->code, $price, $customer_id);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }
}
