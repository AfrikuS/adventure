<?php

namespace App\Repositories\Work;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\UserMaterial;
use App\Repositories\Work\Team\TeamOrderMaterialRepository;
use Illuminate\Database\Eloquent\Collection;

class UserMaterialsRepository
{
    public static function getMaterialsByUser($worker)
    {
        $userMaterials = UserMaterial::
            select('id', 'code', 'value')
            ->where('user_id', $worker->id)
            ->get();

        return $userMaterials;
    }

    /** @deprecated  @see WorkerReposi */
    public static function getSingleUserMaterialByCode($user, string $materialCode): UserMaterial
    {
        return UserMaterial::
            select('id', 'code', 'value')
            ->where('user_id', $user->id)
            ->where('code', $materialCode)
            ->firstOrFail();
    }

    // todo review two methods
    /** @deprecated  */
    public static function hasUserNeedMaterialAmount($user, OrderMaterials $orderMaterial): bool
    {
        $userMaterial = UserMaterialsRepository::getSingleUserMaterialByCode($user, $orderMaterial->code);

        $needAmount = $orderMaterial->need - $orderMaterial->stock;

        return $needAmount <= $userMaterial->value;
    }
    /** @deprecated  */
    public static function hasUserNeedMaterialAmountForTeam($user, TeamOrderMaterial $orderMaterial): bool
    {
        $userMaterial = UserMaterialsRepository::getSingleUserMaterialByCode($user, $orderMaterial->code);

        $needAmount = $orderMaterial->need - $orderMaterial->stock;

        return $needAmount <= $userMaterial->value;
    }



    public static function getMaterialsSameOrder($user, Order $order)
    {
        $orderMaterials = OrderMaterialsRepository::getOrderMaterials($order);

        $materialsCodes = $orderMaterials->map(function ($material, $key) {
            return $material->code;
        })->toArray();

        if (count($materialsCodes) > 0) {
            return UserMaterial::
                select('id', 'code', 'value')
                ->where('user_id', $user->id)
                ->whereIn('code', $materialsCodes)
                ->get();
        }
        else {
            return [];
        }
    }

    public static function getMaterialsSameTeamOrder($user, Collection $orderMaterials)
    {
        $materialsCodes = $orderMaterials->map(function ($material, $key) {
            return $material->code;
        })->toArray();

        if (count($materialsCodes) > 0) {
            return UserMaterial::
                select('id', 'code', 'value')
                ->where('user_id', $user->id)
                ->whereIn('code', $materialsCodes)
                ->get();
        }
        else {
            return [];
        }
    }
}
