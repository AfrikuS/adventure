<?php

namespace App\Modules\Drive\Domain\Commands\Vehicle;

class MountDetail
{
    public $vehicle_id;
    
    public $detail_id;

    public function __construct($detail_id, $vehicle_id)
    {
        $this->vehicle_id = $vehicle_id;
        $this->detail_id = $detail_id;
    }
}
