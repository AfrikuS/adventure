<?php

namespace App\Deleters;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\Team\TeamOrderMaterialRepository;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\TeamOrderSkillRepository;

class WorkDeleter
{
    public static function deleteOrder($id)
    {
        $order = Order::
            select(['id', 'desc', 'kind_work_title', 'price', 'acceptor_user_id', 'status' ])
            ->with('materials')
            ->find($id);

        \DB::beginTransaction();

        try {

//            OrderMaterials::where('order_id', $order->id)->delete();
            foreach ($order->materials as $material) {
                $material->delete();
            }

            Order::destroy($id);
        }
        catch (\Exception $e) {
            \DB::rollBack();
        }
        \DB::commit();
    }



}
