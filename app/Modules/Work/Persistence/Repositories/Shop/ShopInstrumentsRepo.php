<?php

namespace App\Modules\Work\Persistence\Repositories\Shop;

use App\Modules\Work\Domain\Entities\Shop\ShopInstrument;
use App\Modules\Work\Persistence\Dao\Shop\ShopInstrumentsDao;

class ShopInstrumentsRepo
{
    private $instrumentsDao;

    public function __construct(ShopInstrumentsDao $instrumentsDao)
    {
        $this->instrumentsDao = $instrumentsDao;
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

    public function getInstruments()
    {
        $instruments = $this->instrumentsDao->getAll();

        $instrumentsMap = [];

        foreach ($instruments as $instrument) {

            $shopInstrument = new ShopInstrument($instrument);

            $instrumentsMap[$instrument->code] = $shopInstrument;
        }

        return $instrumentsMap;
    }

    public function updatePrice(ShopInstrument $instrument)
    {
        $this->instrumentsDao->updatePrice(
            $instrument->id,
            $instrument->price
        );
    }
}
