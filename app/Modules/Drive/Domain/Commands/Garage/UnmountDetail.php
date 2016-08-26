<?php

namespace App\Modules\Drive\Domain\Commands\Garage;

class UnmountDetail
{
    public $detail_id;

    public function __construct($detail_id)
    {
        $this->detail_id = $detail_id;
    }
}
