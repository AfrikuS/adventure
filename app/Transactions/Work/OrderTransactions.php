<?php

namespace App\Transactions\Work;

use App\Factories\WorkFactory;
use App\Models\Work\Order;
use App\Models\Work\Worker;
use App\Repositories\HeroResourcesRepository;

class OrderTransactions
{
    public static function transferMaterialFromWorkerToOrder(Worker $worker, Order $order, string $materialCode)
    {
        $orderMaterial = $order->getMaterialByCode($materialCode);
        $workerMaterial = $worker->getMaterialByCode($materialCode);

        $amount = $orderMaterial->need - $orderMaterial->stock;

        \DB::transaction(function () use ($orderMaterial, $workerMaterial, $amount) {

            $orderMaterial->stock += $amount;
            $orderMaterial->save();

            $workerMaterial->value -=  $amount;
            $workerMaterial->save();
        });

    }
    public static function transferOrderRewardToWorker(Order $order, Worker $worker)
    {
        $skillCode = 'pokraska';
//        $rewardGold = 400;
        
        $workerSkill = $worker->getSkillByCode('pokraska');
        
        if ($workerSkill === null) {
            $workerSkill = WorkFactory::createWorkerSkill($worker, $skillCode);
        }

        $user = $worker->user()->first();
        \DB::transaction(function () use ($workerSkill, $user, $order) {


            $workerSkill->value += 12;
            $workerSkill->save();

            HeroResourcesRepository::addGoldToUser($user, $order->price);
        });
    }
}
