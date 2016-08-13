<?php

namespace App\Lib\Work;

use App\Persistence\Dao\Work\OrderMaterialsDao;
use App\Persistence\Repositories\Work\Catalogs\MaterialsRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;

/** @deprecated  */
class OrderMaterialsGenerator
{
    private $orderRepo;


    public function __construct()
    {
        $this->orderRepo = new OrderRepo();

        $this->orderMaterialsRepo = new OrderMaterialsRepo();
        $this->materialsRepo = new MaterialsRepo();
    }

    public function createRandomMaterials(int $count, int $order_id)
    {
        
//        foreach ($materials as $material) 
//        {
//            $this->orderMaterialsRepo->save($material);
//        }
        
//        return $materials;
    }
}
