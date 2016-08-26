<?php

namespace App\Modules\Drive\Domain\Entities\Garage;

use App\Modules\Drive\Persistence\Dao\DetailsDao;

class Detail
{
    public $id;
    
    public $mount_status;
    
    public $vehicle_id;

    public function __construct($detailData)
    {
        $this->id = $detailData->id;
        $this->mount_status = $detailData->mount_status;
        $this->vehicle_id = $detailData->vehicle_id;
        $this->owner_driver_id = $detailData->owner_driver_id;
    }

    public function mountOn($vehicle_id)
    {
        $this->vehicle_id = $vehicle_id;
        $this->mount_status = DetailsDao::MOUNTED_STATUS;
    }

    public function unmount()
    {
        $this->vehicle_id = null;
        $this->mount_status = DetailsDao::UNMOUNTED_STATUS;
    }

}
