<?php

namespace App\Modules\Drive\Persistence\Repositories;

use App\Exceptions\Persistence\EntityNotFound_Exception;
use App\Infrastructure\IdentityMap;
use App\Modules\Core\Facades\EntityStore;
use App\Modules\Drive\Domain\Entities\DetailOffer;
use App\Modules\Drive\Domain\Entities\Garage\Detail;
use App\Modules\Drive\Persistence\Dao\DetailsDao;
use App\Modules\Drive\Persistence\Dao\DetailsOffersDao;

class DetailsRepo
{
    /** @var DetailsDao */
    private $detailsDao;

    /** @var DetailsOffersDao */
    private $offersDao;

    public function __construct()
    {
        $this->offersDao = new DetailsOffersDao();
        $this->detailsDao = new DetailsDao();
    }

    public function createViaOffer($offer)
    {
        $this->detailsDao->create(
            $offer->title,
            $offer->kind_id,
            $offer->nominal_value,
            $offer->driver_id
        );
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

    public function getUnmountedDetailsByDriver($driver_id)
    {
        $detailsData = $this->detailsDao->getUnmountedDetails($driver_id);
        
        return $detailsData;
    }

    public function findDetail($detail_id)
    {
        $detail = EntityStore::get(Detail::class, $detail_id);

        if (null !== $detail) {

            return $detail;
        }


        $detailData = $this->detailsDao->findDetail($detail_id);

        if (null === $detailData) {

            throw new EntityNotFound_Exception;
        }

        $detail = new Detail($detailData);


        EntityStore::add($detail, $detail->id);

        return $detail;
    }

    public function updateMountStatus(Detail $detail)
    {
        $this->detailsDao->updateMountStatus(
            $detail->id,
            $detail->mount_status,
            $detail->vehicle_id
        );
    }

    public function getVehicleDetailForUnmount($detail_id)
    {
        $detail = EntityStore::get(Detail::class, $detail_id);

        if (null !== $detail) {

            return $detail;
        }

        $detailData = $this->detailsDao->findDetailForUnmount($detail_id);


        $detail = new Detail($detailData);


        EntityStore::add($detail, $detail->id);

        return $detail;
    }
    
    public function deleteOffersByDriverId($driver_id)
    {
        $this->offersDao->deleteByDriver($driver_id);
    }
    
    public function deleteOffer($id)
    {
        $this->offersDao->delete($id);
    }
}
