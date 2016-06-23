<?php

namespace App\Domain\Work;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\UserMaterial;
use App\Repositories\Work\OrderMaterialsRepository;

class MaterialsActions
{
    /** @deprecated  */
    public static function transferMaterialFromUserToOrder($user, Order $order, OrderMaterials $orderMaterial, int $materialValue)
    {
//        $userMaterial = OrderMaterialsRepository::getUserMaterials($user, [$orderMaterial->code])->first();
//
//        \DB::transaction(function () use ($orderMaterial, $userMaterial, $materialValue) {
//
//            $orderMaterial->stock += $materialValue;
//            $orderMaterial->save();
//            $userMaterial->value -=  $materialValue;
//            $userMaterial->save();
//        });
    }

    /** @deprecated  */
    public static function addMaterialToUser($user, $material)
    {
        $userMaterial = UserMaterial::
            select('id', 'value')
            ->firstOrCreate(['user_id' => $user->id, 'code' => $material->code]);

        $userMaterial->increment('value', 10);
    }
}
