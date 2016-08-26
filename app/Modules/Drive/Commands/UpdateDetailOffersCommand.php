<?php

namespace App\Modules\Drive\Commands;

use App\Models\Drive\Catalogs\DetailTitle;
use App\Models\Drive\DetailOffer;
use App\Modules\Drive\Domain\Services\ShopService;
use App\Modules\Drive\Persistence\Repositories\CatalogsRepo;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;
use App\Repositories\Drive\DetailRepository;

class UpdateDetailOffersCommand
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
        $this->shopRepo = app('DriveShopRepo');
    }

    public function updateOffers($driver_id)
    {

        $shopService = new ShopService();

        \DB::beginTransaction();
        try {

                $shopService->createOffers($driver_id, $count = 2);
            
            
        }
        catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();
    }

}
