<?php

namespace App\Transactions\Work\Team;

use App\Models\Work\Team\TeamOrder;
use App\Models\Work\UserMaterial;
use App\Models\Work\Worker;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\WorkerRepository;

class TeamOrderTransactions
{
    public static function transferMaterialFromUserToOrder(Worker $worker, TeamOrder $order, string $materialCode)
    {
        $orderMaterial = TeamOrderRepository::getMaterialByCode($order, $materialCode);

        /** @var $userMaterial WorkerMaterial */
        $userMaterial = WorkerRepository::getMaterialByCode($worker, $materialCode);
        $amount = $orderMaterial->need - $orderMaterial->stock;

        \DB::transaction(function () use ($orderMaterial, $userMaterial, $amount) {
            $orderMaterial->stock += $amount;
            $orderMaterial->save();
            $userMaterial->value -=  $amount;
            $userMaterial->save();
        });
    }

    public static function applySkillToOrder(Worker $worker, TeamOrder $order, string $skillCode)
    {
        $orderSkill = TeamOrderRepository::getSkillByCode($order, $skillCode);
        
        \DB::transaction(function () use ($worker, $orderSkill, $skillCode) {
            $userSkill = WorkerRepository::getSkillByCode($worker, $skillCode);

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
