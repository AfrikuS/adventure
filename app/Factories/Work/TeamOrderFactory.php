<?php

namespace App\Factories\Work;

use App\Models\Work\OrderMaterials;
use App\Models\Work\OrderSkill;

class TeamOrderFactory
{
    public static function createTeamOrderMaterial($order, string $code)
    {
        return OrderMaterials::create([
            'order_id' => $order->id,
            'code' => $code,
            'need' => 0,
            'stock' => 0,
        ]);
    }

    public static function createTeamOrderSkill($order, string $code)
    {
        return OrderSkill::create([
            'order_id' => $order->id,
            'code' => $code,
            'need_times' => 0,
            'stock_times' => 0,
        ]);
    }
}
