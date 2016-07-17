<?php

namespace App\Commands\Work\IndividualOrder;

use App\Entities\Work\OrderEntity;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Catalogs\Skill;
use App\Repositories\Work\OrderRepositoryObj;

class GenerateOrderCommand
{
    /** @var OrderRepositoryObj */
    private $orderRepo;

    public function __construct(OrderRepositoryObj $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function generateOrder() // createWorkOrderWithMaterials
    {
        $skill = Skill::get()->random();

        $faker = \Faker\Factory::create();
        $materialsCodes = Material::get(['id', 'code'])->pluck('code');

        \DB::beginTransaction();
        try {


            $desc = 'fence';
            $price = rand(74, 90);
            $customer_id = \Auth::id();


            $order = $this->orderRepo->createOrderModel($desc, $skill->code, $price, $customer_id);

            $count = 2;

            for ($i = 0; $i < $count; $i++) { // wtf todo
                $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());

                $this->orderRepo->createMaterial($order->id, $materialCode, $need = 2);

            }


        }
        catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();
    }

}
