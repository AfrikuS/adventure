<?php

namespace App\Modules\Work\Domain\Services\Shop;

use App\Models\Work\PriceMaterial;
use App\Modules\Work\Persistence\Repositories\Shop\ShopInstrumentsRepo;
use App\Modules\Work\Persistence\Repositories\Shop\ShopMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Shop\ShopRepo;

class ShopService
{
    /** @var ShopRepo */
    private $shopRepo;
    
    /** @var ShopMaterialsRepo */
    private $materials;

    public function __construct(
        ShopRepo $shopRepo, 
        ShopMaterialsRepo $materials, 
        ShopInstrumentsRepo $instruments
    )
    {
        $this->shopRepo = $shopRepo;
        $this->materials = $materials;
        $this->instruments = $instruments;
    }

    public function updateMaterialsPrices()
    {
        $materials = $this->shopRepo->getMaterials();

        foreach ($materials as $material) {
            
            $material->price = rand(3, 7);
            $this->materials->updatePrice($material);
        }
    }

    public function updateInstrumentsPrices()
    {
        $instruments = $this->shopRepo->getInstruments();

        foreach ($instruments as $instrument) {

            $instrument->price = rand(483, 794);
            $this->instruments->updatePrice($instrument);
        }
    }
}
