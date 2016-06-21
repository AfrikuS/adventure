<?php

namespace App\Repositories\Work;

use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;

class CatalogsRepository
{
    public static function createTeamOrderMaterial(TeamOrder $order, string $code)
    {
        return TeamOrderMaterial::create([
            'teamorder_id' => $order->id,
            'code' => $code,
            'need' => 0,
            'stock' => 0,
        ]);
    }

    public static function createTeamOrderSkill(TeamOrder $order, string $code)
    {
        return TeamOrderSkill::create([
            'teamorder_id' => $order->id,
            'code' => $code,
            'need_times' => 0,
            'stock_times' => 0,
        ]);
    }
}
