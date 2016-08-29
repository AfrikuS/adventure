<?php

namespace App\Modules\Geo\Domain\Entities\Business;

use App\Exceptions\Commands\Geo\OneRoutePointException;
use App\Exceptions\Commands\Geo\RouteCommitedException;

class TravelRoute
{
    const STATUS_DRAFT     = 'drafting';
    const STATUS_COMMITTED = 'committed';

    public $id;
    public $status;

    public $points;

    public function __construct(\stdClass $routeData)
    {
        $this->id = $routeData->id;
        $this->status = $routeData->status;
    }

    public function setPoints(array $points)
    {
        $this->points = $points;
    }

    
    
    public function addPoint($point)
    {
        if ($this->status === self::STATUS_DRAFT) {

            $this->model->points()->save($point);
        }
        else {

            throw new RouteCommitedException;
        }
    }

    public function commit()
    {
        if ($this->status === self::STATUS_DRAFT) {

//            $this->stateMachine->apply('commit');


//            $this->model->update(['status' => $this->state]);
            $this->status = self::STATUS_COMMITTED;
        }
        else {

            throw new RouteCommitedException;
        }
    }

    public function uncommit()
    {
        $this->status = self::STATUS_DRAFT;
    }

    public function nodesCount()
    {
        return count($this->points);
    }

}
