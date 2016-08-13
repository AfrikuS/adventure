<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Models\Work\Order\Materials;
use App\Persistence\Models\Work\Shop;
use App\Persistence\Models\Work\Shop\ShopInstrumentDto;
use App\Persistence\Models\Work\Shop\ShopMaterial;

class ShopRepo
{
    /** @var ShopMaterialsRepo */
    private $shopMaterialsRepo;

    /** @var  ShopInstrumentsRepo */
    private $shopInstrumentsRepo;

    public function __construct()
    {
        $this->shopMaterialsRepo = new ShopMaterialsRepo();
        $this->shopInstrumentsRepo = new ShopInstrumentsRepo();
    }

    public function getShopWithMaterials()
    {
        $materials = $this->shopMaterialsRepo->getMaterials();
        
        $materials = new Materials($materials, null);
        
        return new Shop($materials);
    }

    public function findMaterialByCode($code)
    {
        $materialData = $this->shopMaterialsRepo->getMaterialByCode($code);
        
        return new ShopMaterial($materialData->code, 50, $materialData->price);
    }

    public function findInstrumentByCode($code)
    {
        $instrumentData = $this->shopInstrumentsRepo->getByCode($code);

        return new ShopInstrumentDto($instrumentData->code, 7, $instrumentData->price);
    }
}
