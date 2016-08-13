<?php

namespace App\Persistence\Services\Work\Order;

use App\Persistence\Repositories\Work\Catalogs\MaterialsRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;

class OrderBuilderService
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

    public function generateMaterials($order_id, $count)
    {
        $generateMaterialsEvent = new GenerateMaterialsEvent(
            $this->materialsRepo, 
            $this->orderMaterialsRepo
        ); 

        $generateMaterialsEvent->handle($order_id, $count);
    }

    public function generateOrderData($customer_id)
    {
        $orderRepo = new OrderRepo();

        $skill = 'kladka_kirpicha'; // Skill::get()->random();
        $desc = 'fence';
        $price = rand(74, 90);
        
        $orderDataDto = new OrderDataDto($desc, $skill, $price, $customer_id);

        
        
        $createOrderData = new CreateOrderDataEvent($orderRepo);

        $order_id = $createOrderData->handle($orderDataDto);

        
        
//        $this->generateMaterials($order_id, 2);


//        $order = $this->orderRepo->createOrderModel($desc, $skill, $price, $customer_id);
//
//        $count = 2;
//
//        for ($i = 0; $i < $count; $i++) { // wtf todo
//            $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());
//
//            $this->orderRepo->createMaterial($order->id, $materialCode, $need = 2);
//
//        }
    }
}
