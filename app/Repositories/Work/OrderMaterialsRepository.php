<?php

namespace App\Repositories\Work;

use App\Models\Work\WorkMaterial;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\UserMaterial;

class OrderMaterialsRepository
{
    public static function getOrderMaterials(Order $order)
    {
        $orderMaterials = OrderMaterials::
            select('id', 'code', 'need', 'stock')
            ->where('order_id', $order->id)
            ->get();

        return $orderMaterials;
    }


    public static function deleteStockedMaterial(OrderMaterials $material)
    {
        OrderMaterials::destroy($material->id);
    }

    /** @deprecated  */ // todo by code only
    public static function getOrderMaterialById($orderMaterial_id)
    {
        $orderMaterial = OrderMaterials::
            find($orderMaterial_id, ['id', 'code', 'need', 'stock']);

        return $orderMaterial;
    }

    // todo check twice where
    public static function getOrderMaterialByCode(Order $order, string $materialCode)
    {
        $orderMaterial = OrderMaterials::
            select('id', 'code', 'need', 'stock')
            ->where('order_id', $order->id)
            ->where('code', '=', $materialCode)
            ->firstOrFail();

        return $orderMaterial;
    }

    public static function getSingleOrderMaterialByCode(Order $order, string $materialCode)
    {
        return OrderMaterials::
            select('id', 'code', 'value')
            ->where('order_id', $order->id)
            ->where('code', $materialCode)
            ->first();
    }

}
