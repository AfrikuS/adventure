<?php

namespace App\StateMachines\Geo;

use App\Exceptions\Commands\Geo\OneRoutePointException;
use App\Exceptions\Commands\Geo\RouteCommitedException;
use App\Models\Geo\TravelRoute;
use App\StateMachines\ApplicationEntity;
use Symfony\Component\Config\Definition\Exception\Exception;

class TravelRouteEntity extends ApplicationEntity
{
    public function __construct(TravelRoute $route)
    {
        parent::__construct($route);
    }

    public function addPoint($point)
    {
        if ($this->state == 'drafting') {

            $this->model->points()->save($point);
        }
        else {
            throw new RouteCommitedException;
        }
    }

    public function commit()
    {
        if ($this->state == 'drafting') {
            
            $this->stateMachine->apply('commit');

            $lastPoint = $this->model->points->last();
            $lastPoint->update(['status' => 'final']);

            $this->model->update(['status' => $this->state]);
        }
        else {
            throw new RouteCommitedException;
        }
    }

    public function deleteLastPoint()
    {
        if ($this->state == 'drafting') {
            
            if ($this->model->points->count() < 2) {
                
                throw new OneRoutePointException;
            }
            
            $this->model->points->last()->delete();
        }
        else {
            throw new RouteCommitedException;
        }
    }

    protected function getModelClass(): string
    {
        return TravelRoute::class;
    }

    protected function getStates(): array
    {
        return [
            'drafting'        => ['type' => 'initial', 'properties' => []],
            'committed'       => ['type' => 'final',   'properties' => []],
        ];
    }

    protected function getTransitions(): array
    {
        return [
            'commit'  =>              ['from' => ['drafting'],        'to' => 'committed'],
        ];
    }
    
    
}
