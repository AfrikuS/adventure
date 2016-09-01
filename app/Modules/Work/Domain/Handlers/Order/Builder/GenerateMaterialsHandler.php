<?php

namespace App\Modules\Work\Domain\Handlers\Order\Builder;

use App\Modules\Work\Domain\Commands\Order\Builder\GenerateMaterials;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;

class GenerateMaterialsHandler
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

    public function handle(GenerateMaterials $command)
    {
        $faker = \Faker\Factory::create();

        $materialsCodes = $this->materialsRepo->getCodes();


        for ($i = 0; $i < $command->count; $i++)
        {
            $code = $faker->unique()->randomElement($materialsCodes);

            $this->orderMaterialsRepo->createOrderMaterial($command->order_id, $code, $need = 2);
        }
    }
}
