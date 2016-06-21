<?php

namespace App\Repositories\Macro;

use App\Models\Macro\Resources;
use App\Models\Macro\Timer;
use Illuminate\Support\Facades\DB;

class ResourcesRepository
{
    public static function decrementResourceByUser($user_id, $resource, $value)
    {
        return Resources::find($user_id)->decrement($resource, $value);
    }
}
