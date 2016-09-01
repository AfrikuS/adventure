<?php

namespace App\Modules\Work\Domain\Services\Order;

use App\Modules\Work\Domain\Commands\Order\Builder\CreateOrderData;
use App\Modules\Work\Domain\Commands\Order\Builder\GenerateMaterials;
use App\Modules\Work\Domain\Commands\Order\Builder\GenerateSkills;
use App\Modules\Work\Domain\Handlers\Order\Builder\GenerateMaterialsHandler;
use App\Modules\Work\Persistence\Repositories\Catalogs\MaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
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
    
    /** @var OrdersRepo */
    private $orders;

    public function __construct()
    {
        $this->materialsRepo = app('CatalogMaterialsRepo');
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
        $this->skillsRepo = app('OrderSkillsRepo');
        $this->orders = app('OrdersRepo');
    }

    public function generateOrderData($customer_id)
    {
        $domains = app('DomainsRepo');

        $domainsCollection = $domains->getDomainsCollection();
        
        $domains_ids = $domainsCollection->getIds();


        $faker = \Faker\Factory::create();


        $domain_id = $faker->unique()->randomElement($domains_ids);


        $desc = 'fence';
        $price = rand(274, 390);

        
        
        $createOrderData = new CreateOrderData($desc, $domain_id, $price, $customer_id);

        $order_id = Bus::dispatch($createOrderData);
    }

    public function generateMaterials($order_id, $count)
    {
        $generateMaterials = new GenerateMaterials($order_id, $count);

        Bus::dispatch($generateMaterials);
    }

    public function generateSkill($order_id, $need)
    {
        $generateSkills = new GenerateSkills($order_id, $need);

        Bus::dispatch($generateSkills);
    }
}
