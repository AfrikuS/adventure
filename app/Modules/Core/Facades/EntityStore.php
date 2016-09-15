<?php

namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class EntityStore extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'entityStore';
    }
}
