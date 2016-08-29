<?php

namespace App\Modules\Geo\Domain\Entities\Business;

use App\Exceptions\Commands\Geo\OneRoutePointException;
use App\Exceptions\Commands\Geo\RouteCommitedException;
use Finite\Exception\StateException;

class TravelRoute
{
    const STATUS_DRAFT     = 'drafting';
    const STATUS_COMMITTED = 'committed';
    const MINIMAL_NODES_COUNT = 2;

    public $id;
    public $status;
    public $title;
    public $user_id;

    public $points;

    public function __construct(\stdClass $routeData)
    {
        $this->id = $routeData->id;
        $this->status = $routeData->status;
        $this->title = $routeData->title;
        $this->user_id = $routeData->user_id;
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

    public function firstPoint()
    {
        return head($this->points);
    }

    public function lastPoint()
    {
        return last($this->points);
    }

    public function getNextPointBy($currPoint_id)
    {
        foreach ($this->points as $index => $point) {

            if ($point->id === $currPoint_id) {

                if ($point->status === RoutePoint::STATUS_FINAL) {
                    
                    return null; // vaoyage is finished
                }
                
                return $this->points[$index + 1];
            }
        }
        
        throw new StateException;
    }

}
