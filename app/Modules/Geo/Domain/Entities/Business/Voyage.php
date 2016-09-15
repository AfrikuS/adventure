<?php

namespace App\Modules\Geo\Domain\Entities\Business;

class Voyage
{
    const STATUS_READY    = 'ready';
    const STATUS_IN_SAIL  = 'in_sail';
    const STATUS_FINISHED = 'finished';

    /*    'states' => [
        'ready_to_start' => ['type' => 'initial', 'properties' => []],
        'in_sail'        => ['type' => 'normal',   'properties' => []],
        'staying'        => ['type' => 'normal',   'properties' => []],
        //                'trading'        => ['type' => 'normal', 'properties' => []],
        'finished'       => ['type' => 'final',   'properties' => []],
    ],
    'transitions' => [
        'begin'       =>  ['from' => ['ready_to_start'],   'to' => 'in_sail'],
        'moor'        =>  ['from' => ['in_sail'], 'to' => 'staying'],
        //                'start_trade' =>  ['from' => ['in_sail'], 'to' => 'trading'],
        'sail_next'   =>  ['from' => ['staying'], 'to' => 'in_sail'],
        'finish'      =>  ['from' => ['staying'], 'to' => 'finished'],
    ]*/


    public $id;
    public $status;
    public $route_id;
    public $point_id;
    public $ship_id;

    public function __construct(\stdClass $voyageData)
    {
        $this->id       = $voyageData->id;
        $this->status   = $voyageData->status;
        $this->route_id = $voyageData->route_id;
        $this->point_id = $voyageData->point_id;
        $this->ship_id  = $voyageData->ship_id;
    }

    public function moor()
    {
        $this->status = self::STATUS_READY;
    }

    public function inSail()
    {
        $this->status = self::STATUS_IN_SAIL;
    }

    public function finish()
    {
        $this->status = self::STATUS_FINISHED;
    }
}
