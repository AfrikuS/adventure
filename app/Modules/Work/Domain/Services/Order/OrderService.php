<?php

namespace App\Modules\Work\Domain\Services\Order;

use App\Modules\Work\Domain\Commands\Order\AcceptOrder;
use App\Modules\Work\Domain\Commands\Order\DeleteOrder;
use App\Modules\Work\Domain\Commands\Order\Status\OrderAccepted;
use App\Modules\Work\Domain\Commands\Order\Status\OrderCompleted;
use App\Modules\Work\Domain\Commands\Order\Status\OrderEstimated;
use App\Modules\Work\Domain\Commands\Order\Status\OrderStockedMaterials;
use App\Modules\Work\Domain\Commands\Order\StockSkill;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use Illuminate\Support\Facades\Bus;

class OrderService
{
    /** @var OrderRepo */
    private $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
    }

    public function accept($order_id, $worker_id)
    {
        $acceptOrder = new AcceptOrder($order_id, $worker_id);

        Bus::dispatch($acceptOrder);


        // as callback, event

        $setStatusAccepted = new OrderAccepted($order_id);

        Bus::dispatch($setStatusAccepted);
    }

    public function estimate($order_id)
    {
        $setStatusEstimated = new OrderEstimated($order_id);

        Bus::dispatch($setStatusEstimated);
    }

    public function checkStatusAfterStockMaterial($order_id)
    {
        $stockDataDto = $this->orderRepo->getStockMaterialsData($order_id);


        // if from id-map - good
//        $order = $this->orderRepo->findOrderWithMaterialsById($order_id);


        if ($stockDataDto->isStockCompleted()) {

            $orderStockedMaterials = new OrderStockedMaterials ($order_id);
            
            Bus::dispatch($orderStockedMaterials);
        }
    }

    public function deleteWithMaterialsAndSkills($order_id)
    {
        $deleteOrder = new DeleteOrder($order_id);

        Bus::dispatch($deleteOrder);
    }

    /** @deprecated */
    public function cancelStatusApplyingSkill($order_id)
    {
        $order = $this->orderRepo->find($order_id);

        $order->setStockSkillsStatus();

        $this->orderRepo->updateStatus($order);
    }

    public function stockSkill($order_id, $worker_id)
    {
        $command = new StockSkill($order_id);
        
        Bus::dispatch($command);


        



        /** @var OrderSkillsRepo $skills */
        $skills = app('OrderSkillsRepo');
        
        $skill = $skills->findSingleByOrder($order_id);
        

        $isFullStock = $skill->isFullStock(); //$skills->isFullStockSkills($order_id);

        
        return $isFullStock;
   }

    public function completeWork($order_id)
    {
        $setStatusCompleted = new OrderCompleted($order_id);

        Bus::dispatch($setStatusCompleted);
    }
}
