<?php

namespace App\Modules\Drive\Domain\Entities;

class DetailOffer
{
    public $id;
    public $title;
    public $kind_id;
    public $nominal_value;
    public $driver_id;

    public function __construct($offerData)
    {
        $this->id = $offerData->id;
        $this->title = $offerData->title;
        $this->kind_id = $offerData->kind_id;
        $this->nominal_value = $offerData->nominal_value;
        $this->driver_id = $offerData->driver_id;
    }
}
