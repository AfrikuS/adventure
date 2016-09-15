<?php

namespace App\Modules\Drive\Domain\Entities\Shop;

class DetailOffer
{
    public $id;
    public $title;
    public $kind_id;
    public $nominal_value;
    public $driver_id;

    public function __construct(\stdClass $detailOfferData)
    {
        $this->id = $detailOfferData->id;
        $this->title = $detailOfferData->title;
        $this->kind_id = $detailOfferData->kind_id;
        $this->nominal_value = $detailOfferData->nominal_value;
        $this->driver_id = $detailOfferData->driver_id;
    }
}
