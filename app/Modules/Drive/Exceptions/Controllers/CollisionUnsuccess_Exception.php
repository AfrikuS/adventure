<?php

namespace App\Modules\Drive\Exceptions\Controllers;

use App\Modules\Drive\Domain\Entities\Raid\RobberyVehicle;
use App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions\CollisionResult;

class CollisionUnsuccess_Exception extends \Exception
{
    /** @var CollisionResult */
    public $collisionResult;
    
    /** @var RobberyVehicle */
    public $vehicle;

    public function __construct(CollisionResult $collisionResult, RobberyVehicle $vehicle)
    {
        $this->collisionResult = $collisionResult;
        $this->vehicle = $vehicle;
    }
}
