<?php

namespace App\Modules\Drive\Exceptions\Controllers;

use App\Modules\Drive\Domain\Lib\Raid\Robbery\Collisions\CollisionResult;

class CollisionSuccess_Exception extends \Exception
{
    /** @var CollisionResult */
    public $collisionResult;

    public function __construct(CollisionResult $collisionResult)
    {
        $this->collisionResult = $collisionResult;
    }
}
