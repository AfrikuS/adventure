<?php

namespace App\Repositories\Macro;

use App\Models\Macro\Building;

class BuildingsRepository
{

    public static function getBuildingsWithConcreteByUser($user)
    {
        $buildings = Building::
            select('id', 'kind', 'count', 'user_id', 'concrete_building_id')
            ->whereNotNull('concrete_building_id')
            ->whereAnd('user_id', $user->id)
            ->with(['concrete' => function ($query) {
                $query->select('id', 'title');
            }])
            ->get();
        
        return $buildings;
    }

    public static function getFreeBuildingsByUser($user)
    {
        $freeBuildings = Building::
            select('id', 'kind', 'user_id', 'concrete_building_id')
            ->whereAnd('user_id', $user->id)
            ->whereNull('concrete_building_id')
            ->get();

        return $freeBuildings;
    }

    public static function createBuilding($user)
    {
        Building::create([
            'user_id' => $user->id,
            'count' => 40,
            'kind' => '',
        ]);
    }
}
