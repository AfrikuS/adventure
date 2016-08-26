<?php

namespace App\Modules\Work\Domain\Handlers\Order\Builder;

use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;

class GenerateMaterialsHandler
{
    /** @var MaterialsRepo */
    private $materialsRepo;

    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    public function __construct()
    {
        $this->materialsRepo = app('CatalogMaterialsRepo');
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
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
