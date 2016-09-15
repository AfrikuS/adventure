<?php

namespace App\Modules\Drive\Domain\Services;

use App\Modules\Drive\Domain\Commands\Shop\CreateDetailOffer;
use App\Modules\Drive\Domain\Commands\Shop\PurchaseDetail;
use App\Modules\Drive\Domain\Commands\DeleteDetailOffer;
use App\Modules\Drive\Persistence\Repositories\CatalogsRepo;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;
use Illuminate\Support\Facades\Bus;

class ShopService
{
    /** @var DetailsRepo */
    private $detailsRepo;

    /** @var CatalogsRepo */
    private $catalogsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
        $this->catalogsRepo = app('DriveCatalogsRepo');
    }

    public function purchaseDetail($detailOffer_id, $driver_id)
    {
//        $detailOffer = $this->detailsRepo->findOffer($detailOffer_id);




        $buyDetail = new PurchaseDetail($detailOffer_id, $driver_id);

        Bus::dispatch($buyDetail);
        
        
        $deleteDetailOffer = new DeleteDetailOffer($detailOffer_id);

        Bus::dispatch($deleteDetailOffer);
    }

    public function createOffers($driver_id, $count)
    {
        $detailsTitlesArr = $this->catalogsRepo->getDetailsTitles();


        // delete old offers
        $this->detailsRepo->deleteOffersByDriverId($driver_id);


        $faker = \Faker\Factory::create();


        for ($i = 0; $i < $count; $i++)
        {
            $detailDraft = $faker->randomElement($detailsTitlesArr);

            $nominal = rand(12, 25);


            $createDetailOffer = new CreateDetailOffer(
                $detailDraft->title,
                $detailDraft->kind_id,
                $nominal,
                $driver_id
            );

            Bus::dispatch($createDetailOffer);
        }

    }

}
