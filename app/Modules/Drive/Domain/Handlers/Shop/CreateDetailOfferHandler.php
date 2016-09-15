<?php

namespace App\Modules\Drive\Domain\Handlers\Shop;

use App\Modules\Drive\Domain\Commands\Shop\CreateDetailOffer;
use App\Modules\Drive\Persistence\Repositories\ShopRepo;

class CreateDetailOfferHandler
{
    /** @var ShopRepo */
    private $shopRepo;

    public function __construct()
    {
        $this->shopRepo = app('DriveShopRepo');
    }

    public function handle(CreateDetailOffer $command)
    {
        $this->shopRepo->createOffer(
            $command->title,
            $command->kind_id,
            $command->nominal,
            $command->driver_id
        );
    }
}
