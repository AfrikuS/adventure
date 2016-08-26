<?php

namespace App\Modules\Drive\Commands\Shop;

use App\Exceptions\DetailNotFoundExeption;
use App\Modules\Drive\Domain\Services\ShopService;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;
use App\Repositories\Drive\DetailRepository;

class BuyDetailCommand
{
    /** @var  DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
    }

    public function buyDetail($detailOffer_id, $driver_id)
    {
        
        
        $shopService = new ShopService();


        
        $this->validateCommand($detailOffer_id, $driver_id);




        \DB::beginTransaction();
        try {

            $shopService->purchaseDetail($detailOffer_id, $driver_id);

        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    private function validateCommand($offer_id, $driver_id)
    {
        $offer = $this->detailsRepo->findOffer($offer_id);

        if ($offer->driver_id != $driver_id) {

            throw new DetailNotFoundExeption;
        }
    }
}
