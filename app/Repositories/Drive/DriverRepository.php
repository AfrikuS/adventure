<?php

namespace App\Repositories\Drive;

use App\Models\Drive\Driver;

class DriverRepository
{

    public function findById($user_id)
    {
        return Driver::find($user_id);
    }

    public function createDriver($user_id)
    {
        return Driver::create([
            'id' => $user_id,
        ]);
    }
}
