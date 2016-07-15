<?php

namespace App\Repositories\Work\Team;

use Illuminate\Database\Eloquent\Collection;

class TeamOrderMaterialRepository
{
    /**
     *
     * @param  TeamOrder $order
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @deprecated
     */
    public static function getOrderMaterials(TeamOrder $order): Collection
    {
        return $order->materials;
    }

    /** @deprecated  */
    public static function deleteStockedMaterial(TeamOrderMaterial $material)
    {
        TeamOrderMaterial::destroy($material->id);
    }
}
