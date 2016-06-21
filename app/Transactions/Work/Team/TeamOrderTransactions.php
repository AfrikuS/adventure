<?php

namespace App\Transactions\Work\Team;

use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Team\TeamWorker;
use App\Models\Work\WorkMaterial;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\Team\TeamOrderMaterial;
use App\Models\Work\Team\TeamOrderSkill;
use App\Models\Work\UserMaterial;
use App\Models\Work\WorkSkill;
use App\Models\Work\WorkUserSkill;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\SkillRepository;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\TeamWorkerRepository;
use App\Repositories\Work\UserMaterialsRepository;

class TeamOrderTransactions
{
    public static function transferMaterialFromUserToOrder(TeamWorker $worker, TeamOrder $order, string $materialCode)
    {
        $orderMaterial = TeamOrderRepository::getMaterialByCode($order, $materialCode);

        /** @var $userMaterial UserMaterial */
        $userMaterial = TeamWorkerRepository::getMaterialByCode($worker, $materialCode);
        $amount = $orderMaterial->need - $orderMaterial->stock;

        \DB::transaction(function () use ($orderMaterial, $userMaterial, $amount) {
            $orderMaterial->stock += $amount;
            $orderMaterial->save();
            $userMaterial->value -=  $amount;
            $userMaterial->save();
        });
    }

    public static function applySkillToOrder(TeamWorker $worker, TeamOrder $order, string $skillCode)
    {
        $orderSkill = TeamOrderRepository::getSkillByCode($order, $skillCode);
        
        \DB::transaction(function () use ($worker, $orderSkill, $skillCode) {
            $userSkill = TeamWorkerRepository::getSkillByCode($worker, $skillCode);

            $orderSkill->stock_times++;
            $orderSkill->save();

//            addSkillToWorker
            $userSkill->increment('value', 10);
        });
    }
//    public static function transferOrderRewardToUser(Order $order, $user)
//    {
//        \DB::transaction(function () use ($order) {
//
//            $skillCode = $order->kind_work_title;
//
//            SkillRepository::addSkillToUserByCode(auth()->user(), $skillCode);
//
//            HeroResourcesRepository::addGoldToUser(auth()->user(), $order->price);
//        });
//
//        return true;
//    }
}
