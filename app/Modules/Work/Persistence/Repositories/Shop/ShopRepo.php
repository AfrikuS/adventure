<?php

namespace App\Modules\Work\Persistence\Repositories\Shop;

use App\Modules\Work\Domain\Entities\Shop\ShopInstrument;
use App\Modules\Work\Domain\Entities\Shop\ShopMaterial;

class ShopRepo
{
    /** @var ShopMaterialsRepo */
    private $shopMaterialsRepo;

    /** @var  ShopInstrumentsRepo */
    private $shopInstrumentsRepo;

    public function __construct(ShopMaterialsRepo $materials, ShopInstrumentsRepo $instruments)
    {
        $this->shopMaterialsRepo = $materials;
        $this->shopInstrumentsRepo = $instruments;
    }

/*    public function getShopWithMaterials()
    {
        $materials = $this->shopMaterialsRepo->getMaterialsMap();
        
        $materials = new Materials($materials, null);
        
        return new Shop($materials);
    }*/

    public function findMaterialByCode($code)
    {
        $materialData = $this->shopMaterialsRepo->getMaterialByCode($code);
        
        return new ShopMaterial($materialData);
    }

    public function findInstrumentByCode($code)
    {
        $instrumentData = $this->shopInstrumentsRepo->getByCode($code);

        return new ShopInstrument($instrumentData);
    }

    public function getMaterials()
    {
        $materials = $this->shopMaterialsRepo->getMaterials();

        return $materials;
    }

    public function getInstruments()
    {
        $instruments = $this->shopInstrumentsRepo->getInstruments();

        return $instruments;
    }
}
