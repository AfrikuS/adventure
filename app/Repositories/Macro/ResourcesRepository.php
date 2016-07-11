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

    public static function createPolitic($user_id)
    {
        return Resources::create([
            'id' => $user_id,
            'food' => 5000,
            'tree' => 9000,
            'water' => 4000,
            'free_people' => 700,
        ]);
    }

}
