<?php

namespace App\Repositories\Work\Team;

use App\Models\Work\Material;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\UserMaterial;
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
