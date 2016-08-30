<?php

namespace App\Modules\Drive\Domain\Entities\Garage;

use App\Modules\Drive\Domain\Entities\Driver;

class Detail
{
    const MOUNTED_STATUS = 'mounted';
    const UNMOUNTED_STATUS = 'unmounted';

    const DETAIL_NORMAL_STATUS = 'normal';

    public $id;
    public $mount_status;
    public $vehicle_id;
    public $owner_driver_id;
    
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
        $this->mount_status = self::MOUNTED_STATUS;
    }

    public function unmount()
    {
        $this->vehicle_id = null;
        $this->mount_status = self::UNMOUNTED_STATUS;
    }

    public function isOwner(Driver $driver)
    {
        return $this->owner_driver_id === $driver->id;
    }

    public function isMounted()
    {
        return $this->mount_status === self::MOUNTED_STATUS;
    }
}
