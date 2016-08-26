<?php

namespace App\Modules\Drive\Domain\Handlers;

use App\Modules\Drive\Domain\Commands\DeleteDetailOffer;
use App\Modules\Drive\Persistence\Repositories\DetailsRepo;

class DeleteDetailOfferHandler
{
    /** @var DetailsRepo */
    private $detailsRepo;

    public function __construct()
    {
        $this->detailsRepo = app('DriveDetailsRepo');
    }

    public function handle(DeleteDetailOffer $command)
    {
        $this->detailsRepo->deleteOffer($command->offer_id);
    }
}
