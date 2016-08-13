<?php

namespace App\Persistence\Services\Work\Order;

use App\Persistence\Repositories\Work\Catalogs\MaterialsRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;

class GenerateMaterialsEvent
{
    /** @var MaterialsRepo */
    private $materialsRepo;

    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct(MaterialsRepo $materialsRepo, OrderMaterialsRepo $orderMaterialsRepo)
    {
        $this->materialsRepo = $materialsRepo;
        $this->orderMaterialsRepo = $orderMaterialsRepo;
    }

    public function handle($order_id, $count)
    {
        $faker = \Faker\Factory::create();

        $materialsCodes = $this->materialsRepo->getCodes();


        for ($i = 0; $i < $count; $i++)
        {
            $code = $faker->unique()->randomElement($materialsCodes);

            $this->orderMaterialsRepo->createOrderMaterial($order_id, $code, $need = 2);

        }

    }
}
