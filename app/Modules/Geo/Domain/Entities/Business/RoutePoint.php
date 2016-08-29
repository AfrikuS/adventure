<?php

namespace App\Modules\Geo\Domain\Entities\Business;

class RoutePoint
{
    const STATUS_FIRST  = 'first';
    const STATUS_NORMAL = 'normal';
    const STATUS_FINAL  = 'final';

    public $id;
    public $status;
    public $route_id;
    public $number;
    public $location_id;
    public $location_title;

    public function __construct(\stdClass $pointData)
    {
        $this->id = $pointData->id;
        $this->status = $pointData->status;
        $this->route_id = $pointData->route_id;
        $this->number = $pointData->number;
        $this->location_id = $pointData->location_id;
        $this->location_title = $pointData->location_title;
    }

    public function setFinal()
    {
        $this->status = self::STATUS_FINAL;
    }

    public function setNormal()
    {
        $this->status = self::STATUS_NORMAL;
    }
}
