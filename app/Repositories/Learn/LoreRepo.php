<?php

namespace App\Repositories\Learn;

use App\Models\Learn\Lore;

class LoreRepo
{
    public function create($user_id)
    {
        $lore = Lore::create([
            'mosaic' => '000000000000000000000000000000',
            'user_id' => $user_id,
            'amount' => 0,
        ]);

        return $lore;
    }
}
