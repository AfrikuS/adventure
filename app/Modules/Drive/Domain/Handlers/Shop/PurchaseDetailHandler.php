<?php

namespace App\Modules\Drive\Domain\Handlers\Shop;

use App\Exceptions\DetailNotFoundExeption;
use App\Modules\Drive\Domain\Commands\Shop\PurchaseDetail;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;

class PurchaseDetailHandler
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = new DetailsRepo();
    }

    public function handle(PurchaseDetail $command)
    {
        $offer = $this->detailsRepo->findOffer($command->offer_id);


        $this->detailsRepo->createViaOffer($offer);
    }
}
