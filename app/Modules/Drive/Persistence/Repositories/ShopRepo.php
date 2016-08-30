<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\Shop\DetailOffer;
use App\Modules\Drive\Persistence\Dao\Catalogs\DetailsKindsDao;
use App\Modules\Drive\Persistence\Dao\DetailsOffersDao;

class ShopRepo
{
    /** @var DetailsOffersDao */
    private $offersDao;

    /** @var DetailsKindsDao */
    private $kindsDao;

    public function __construct(DetailsOffersDao $offersDao, DetailsKindsDao $kindsDao)
    {
        $this->offersDao = $offersDao;
        $this->kindsDao = $kindsDao;
    }

    public function getOffersWithKindsByDriver($driver_id)
    {
        $detailsOffers = $this->offersDao->getWithKindsByDriver($driver_id);

        return $detailsOffers;
    }

    public function createOffer($title, $kind_id, $nominal, $driver_id)
    {
        $this->offersDao->create($title, $kind_id, $nominal, $driver_id);
    }

    public function findOffer($detailOffer_id)
    {
        $offer = EntityStore::get(DetailOffer::class, $detailOffer_id);

        if (null != $offer) {

            return $offer;
        }

        $offerData = $this->offersDao->find($detailOffer_id);


        $offer = new DetailOffer($offerData);

        EntityStore::add($offer, $offer->id);

        return $offer;
    }
}
