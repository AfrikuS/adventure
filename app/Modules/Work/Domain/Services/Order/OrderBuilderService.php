<?php

namespace App\Modules\Work\Domain\Services\Order;

use App\Modules\Work\Domain\Commands\Order\Builder\CreateOrderData;
use App\Modules\Work\Domain\Handlers\Order\Builder\GenerateMaterialsHandler;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use Illuminate\Support\Facades\Bus;

class OrderBuilderService
{
    /** @var MaterialsRepo */
    private $materialsRepo;
    
    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;

    /** @var OrderSkillsRepo */
    private $skillsRepo;
    
    /** @var OrderRepo */
    private $orders;

    public function __construct()
    {
        $this->materialsRepo = app('CatalogMaterialsRepo');
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
        $this->skillsRepo = app('OrderSkillsRepo');
        $this->orders = app('OrderRepo');
    }

    public function generateOrderData($customer_id)
    {
        $domains = app('DomainsRepo');

        $domainsCodes = $domains->getCodes();


        $faker = \Faker\Factory::create();


        $domainCode = $faker->unique()->randomElement($domainsCodes);


        $desc = 'fence';
        $price = rand(274, 390);

        
        
        $createOrderData = new CreateOrderData($desc, $domainCode, $price, $customer_id);

        $order_id = Bus::dispatch($createOrderData);
    }

    public function generateMaterials($order_id, $count)
    {
        $generateMaterialsEvent = new GenerateMaterialsHandler(
            $this->materialsRepo,
            $this->orderMaterialsRepo
        );

        $generateMaterialsEvent->handle($order_id, $count);
    }

    public function generateSkill($order_id, $need)
    {
        $order = $this->orders->find($order_id);
        
        $domainCode = $order->domainCode;
        
//        $domainsCodes = $domains->getCodes();
//
//
//        $faker = \Faker\Factory::create();
//
//
////        for ($i = 0; $i < $count; $i++)
////        {
//            $skillCode = $faker->unique()->randomElement($domainsCodes);

        $this->skillsRepo->createOrderSkill($order_id, $domainCode, $need);
//            $this->orderMaterialsRepo->createOrderMaterial($order_id, $code, $need = 2);
    }
}
