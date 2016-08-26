<?php

namespace App\Modules\Drive\Domain\Commands\Shop;

class CreateDetailOffer
{
    public $title;
    
    public $kind_id;

    public $nominal;
    
    public $driver_id;

    public function __construct($title, $kind_id, $nominal, $driver_id)
    {
        $this->title = $title;
        $this->kind_id = $kind_id;
        $this->nominal = $nominal;
        $this->driver_id = $driver_id;
    }
}
