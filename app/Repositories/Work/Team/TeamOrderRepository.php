<?php

namespace App\Repositories\Work\Team;

use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;

class TeamOrderRepository
{
    public static function getOrderById($id): TeamOrder
    {
        $order = TeamOrder::
            select(['id', 'desc', 'kind_work', 'price', 'acceptor_team_id', 'status' ])
            ->find($id);

        return $order;
    }

//    public static function finishWorks(TeamOrder $order)
//    {
//        $order->update(['status' => 'finished']);
//    }

//    /** @deprecated  */
//    public static function orderReadyToWork(TeamOrder $order): bool
//    {
//        return TeamOrderMaterial::select('id')->where('teamorder_id', $order->id)->count() == 0;
//    }
//
//    public static function isTeamOrderFinishedWorks(TeamOrder $order)
//    {
//        return TeamOrderSkill::select('id')->where('teamorder_id', $order->id)->count() == 0;
//    }

    public static function findOrderWithMaterialsAndSkillsById($id): TeamOrder
    {
        return TeamOrder::select('id', 'price', 'status', 'desc', 'kind_work')
            ->with(['materials' => function ($query) {
                $query->select('id', 'teamorder_id', 'code', 'need', 'stock');
            }])
            ->with(['skills' => function ($query) {
                $query->select('id', 'teamorder_id', 'code', 'need_times', 'stock_times');
            }])
            ->findOrFail($id);
    }

    public static function belongUserToTeamOrder($user, TeamOrder $order)
    {
        if ($team = $order->team) {

            $index = $team->partners->search(function ($partner, $key) use ($user) {
                return $partner->id == $user->id;
            });

            return is_int($index);
        }
        
        return false;
    }

//    public static function getMaterialDataByCode(TeamOrder$order, $materialCode)
//    {
//    }

//    public static function getMaterialByCode(TeamOrder $order, $code)
//    {
//        $index = $order->materials->search(function ($material, $key) use ($code) {
//            return $material->code == $code;
//        });
//
//        if (is_int($index)) {
//            return $order->materials->get($index);
//        }
//        return false;
//    }
//
//    public static function getSkillByCode(TeamOrder $order, $code)
//    {
//        $index = $order->skills->search(function ($skill, $key) use ($code) {
//            return $skill->code == $code;
//        });
//
//        return $order->skills->get($index);
//    }

/*    // attach \ detach todo view
    public static function deleteMaterialByCode(TeamOrder $order, $materialCode)
    {
        $index = $order->materials->search(function ($material, $key) use ($materialCode) {
            return $material->code == $materialCode;
        });

        if (is_int($index)) {
            $order->materials->get($index)->delete();
            return true;
        }

        return false;

    }*/

//    /** @deprecated  */
//    public static function isFinishedStockSkillsByCode(TeamOrder $order, string $skillCode)
//    {
//        $skill = TeamOrderRepository::getSkillByCode($order, $skillCode);
//        
//        return $skill->need_times <= $skill->stock_times;
//    }


//    public static function isFinishedStockMaterials($order): bool
//    {
//        foreach ($order->materials as $material) {
//            if ($material->need > $material->stock) {
//                return false;
//            }
//        }
//
//        return true;
//    }

    public static function getTeamOrders(PrivateTeam $team)
    {
        return $team->orders;
    }

    /*    public static function isOrderReadyToWorks(Order $order)
        {
            return $order->status === 'ready_to_work';
        }
    
    
        // with materials
        public static function deleteOrder(Order $order)
        {
            TeamOrderMaterial::where('order_id', $order->id)->delete();
            Order::destroy($order->id);
        }*/
}
