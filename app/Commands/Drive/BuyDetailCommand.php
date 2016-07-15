<?php

namespace App\Commands\Drive;

use App\Exceptions\DetailNotFoundExeption;
use App\Repositories\Drive\DetailRepository;

class BuyDetailCommand
{
    /** @var  DetailRepository */
    private $detailRepo;

    public function __construct(DetailRepository $detailRepo)
    {
        $this->detailRepo = $detailRepo;
    }

    public function buyDetail($detailOffer_id, $driver_id)
    {
        
        $offer = $this->detailRepo->findOfferById($detailOffer_id);

        if ($offer === null || $offer->driver_id != $driver_id) {
            
            throw new DetailNotFoundExeption;
        }


        \DB::beginTransaction();
        try {

            $this->detailRepo->createByOffer($offer);

            $offer->delete();

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }
}
