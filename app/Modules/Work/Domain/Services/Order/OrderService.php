<?php

namespace App\Modules\Work\Domain\Services\Order;

use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use App\Modules\Work\Domain\Commands\Order\AcceptOrder;
use App\Modules\Work\Domain\Commands\Order\DeleteOrder;
use App\Modules\Work\Domain\Commands\Order\Status\OrderCompleted;
use App\Modules\Work\Domain\Commands\Order\Status\OrderEstimated;
use App\Modules\Work\Domain\Commands\Order\StockMaterial;
use App\Modules\Work\Domain\Commands\Order\StockSkill;
use App\Modules\Work\Domain\Commands\Worker\DecrementMaterial;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use Illuminate\Support\Facades\Bus;

class OrderService
{
    /** @var OrdersRepo */
    private $ordersRepo;

    public function __construct()
    {
        $this->ordersRepo = app('OrdersRepo');
    }

    public function accept($order_id, $worker_id)
    {
        $acceptOrder = new AcceptOrder($order_id, $worker_id);

        Bus::dispatch($acceptOrder);
    }

    public function estimate($order_id)
    {
        $setStatusEstimated = new OrderEstimated($order_id);

        Bus::dispatch($setStatusEstimated);
    }

    public function stockMaterial($worker_id, $order_id, $code)
    {
        /** @var Order $orderWithMaterials */
        $orderWithMaterials = $this->ordersRepo->findOrderWithMaterialsById($order_id);

        $needMaterialAmount = $orderWithMaterials->materials->getRemainMaterialAmount($code);


        
        $decrementMaterial = new DecrementMaterial($worker_id, $code, $needMaterialAmount);

        $stockMaterial = new StockMaterial($order_id, $code, $needMaterialAmount);



        Bus::dispatch($decrementMaterial);

        Bus::dispatch($stockMaterial);
    }


    public function deleteWithMaterialsAndSkills($order_id)
    {
        $deleteOrder = new DeleteOrder($order_id);

        Bus::dispatch($deleteOrder);
    }

    /** @deprecated */
    public function cancelStatusApplyingSkill($order_id)
    {
        $order = $this->ordersRepo->find($order_id);

        $order->setStockSkillsStatus();

        $this->ordersRepo->updateStatus($order);
    }

    public function stockSkill($order_id)
    {
        $command = new StockSkill($order_id);
        
        Bus::dispatch($command);
    }

    public function checkOrderCompleted($order_id, $worker_id)
    {
        /** @var Order $order */
        $order = $this->ordersRepo->findOrderWithSkill($order_id);
        

        if ($order->skill->isFullStock()) {

            $this->completeWork($order_id);

            $this->takeReward($order_id, $worker_id);
        }
    }
    
    public function completeWork($order_id)
    {
        $setStatusCompleted = new OrderCompleted($order_id);

        Bus::dispatch($setStatusCompleted);
    }

    public function takeReward($order_id, $worker_id)
    {
        $order = $this->ordersRepo->find($order_id);


        $incrementGold = new IncrementGold($worker_id, $order->price);

        Bus::dispatch($incrementGold);
    }
}
