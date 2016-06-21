<?php

namespace App\Transactions\Work;

use App\Models\Work\WorkMaterial;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\WorkSkill;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\SkillRepository;
use App\Repositories\Work\UserMaterialsRepository;

class OrderTransactions
{
    public static function transferMaterialFromUserToOrder($user, OrderMaterials $orderMaterial)
    {
        $userMaterial = UserMaterialsRepository::getSingleUserMaterialByCode($user, $orderMaterial->code);
        $amount = $orderMaterial->need - $orderMaterial->stock;

        \DB::transaction(function () use ($orderMaterial, $userMaterial, $amount) {

            $orderMaterial->stock += $amount;
            $orderMaterial->save();
            $userMaterial->value -=  $amount;
            $userMaterial->save();
        });

    }
    public static function transferOrderRewardToUser(Order $order, $user)
    {
        \DB::transaction(function () use ($order) {

            $skillCode = $order->kind_work_title;

            SkillRepository::addSkillToUserByCode(auth()->user(), $skillCode);

            HeroResourcesRepository::addGoldToUser(auth()->user(), $order->price);
        });

        return true;
    }
}
