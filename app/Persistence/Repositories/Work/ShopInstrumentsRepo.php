<?php

namespace App\Persistence\Repositories\Work;

use App\Persistence\Dao\Work\ShopInstrumentsDao;
use App\Persistence\Dao\Work\ShopMaterialsDao;
use App\Persistence\Models\Work\Shop\ShopMaterial;

class ShopInstrumentsRepo
{
    private $instrumentsDao;

    public function __construct()
    {
        $this->instrumentsDao = new ShopInstrumentsDao();
    }

    public function getByCode($code)
    {
        $material = $this->instrumentsDao->findByCode($code);

        return $material;
    }

    public function getPriceByCode($code)
    {
        $material = $this->getByCode($code);
        
       return $material->price;
    }
}
