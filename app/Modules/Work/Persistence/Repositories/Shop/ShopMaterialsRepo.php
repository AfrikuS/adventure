<?php

namespace App\Modules\Work\Persistence\Repositories\Shop;

use App\Modules\Work\Domain\Entities\Shop\ShopMaterial;
use App\Modules\Work\Persistence\Dao\Shop\ShopMaterialsDao;

class ShopMaterialsRepo
{
    private $materialsDao;

    public function __construct(ShopMaterialsDao $materialsDao)
    {
        $this->materialsDao = $materialsDao;
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

/*
    public function getMaterialsMap()
    {
        $materials = $this->materialsDao->getAll();
        
        $materialsMap = [];
        
        foreach ($materials as $material) {
            
            $shopMaterial = new ShopMaterial($material);
            
            $materialsMap[$material->code] = $shopMaterial;
        } 
        
        return $materialsMap;
    }*/

    public function getMaterials()
    {
        $materialsData = $this->materialsDao->getAll();

        $materials = [];
        
        foreach ($materialsData as $material) {
            
            $shopMaterial = new ShopMaterial($material);

            $materials[] = $shopMaterial;
        } 
        
        return $materials;
    }

    public function updatePrice(ShopMaterial $material)
    {
        $this->materialsDao->updatePrice(
            $material->id,
            $material->price
        );
    }
}
