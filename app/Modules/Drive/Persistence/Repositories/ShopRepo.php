<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Drive\Persistence\Dao\Catalogs\DetailsKindsDao;
use App\Modules\Drive\Persistence\Dao\DetailsOffersDao;

class ShopRepo
{
    /** @var DetailsOffersDao */
    private $offersDao;

    /** @var DetailsKindsDao */
    private $kindsDao;

    public function __construct(DetailsOffersDao $offersDao)
    {
        $this->offersDao = $offersDao;
        $this->kindsDao = new DetailsKindsDao();
    }

    public function getOffersWithKindsByDriver($driver_id)
    {
//        $detailsOffers = DetailOffer::select('id', 'kind_id', 'title')
//            ->where('driver_id', $driver_id)
//            ->with('kind')
//            ->get();

        $detailsOffers = $this->offersDao->getWithKindsByDriver($driver_id);

        return $detailsOffers;

    }

    public function createOffer($title, $kind_id, $nominal, $driver_id)
    {
        $this->offersDao->create($title, $kind_id, $nominal, $driver_id);

    }

}
