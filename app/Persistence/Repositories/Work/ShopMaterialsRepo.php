<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\ShopMaterialsDao;
use App\Persistence\Models\Work\Shop\ShopMaterial;

class ShopMaterialsRepo
{
    private $materialsDao;

    public function __construct()
    {
        $this->materialsDao = new ShopMaterialsDao();
    }

    public function getMaterialByCode($code)
    {
        $material = $this->materialsDao->findByCode($code);

        return $material;
    }

    public function getPriceByCode($code)
    {
        $material = $this->getMaterialByCode($code);
        
       return $material->price;
    }

    public function getMaterials()
    {
        $materials = $this->materialsDao->getAll();
        
        $materialsMap = [];
        
        foreach ($materials as $material) {
            
            $shopMaterial = new ShopMaterial($material->code, 60, $material->price);
            
            $materialsMap[$material->code] = $shopMaterial;
        } 
        
        return $materialsMap;
    }
}
