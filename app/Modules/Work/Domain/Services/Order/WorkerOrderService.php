<?php

namespace App\Modules\Work\Domain\Services\Order;

use App\Modules\Employment\Domain\Services\Lore\LearnLoreService;
use App\Modules\Hero\Domain\Commands\Resources\IncrementGold;
use App\Modules\Work\Domain\Commands\Order\StockMaterial;
use App\Modules\Work\Domain\Commands\Worker\DecrementMaterial;
use App\Modules\Work\Persistence\Repositories\Order\OrderMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerMaterialsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Illuminate\Support\Facades\Bus;

class WorkerOrderService
{
    /** @var OrderRepo */
    private $orderRepo;

    /** @var WorkerRepo */
    private $workerRepo;
    
    /** @var WorkerMaterialsRepo */
    private $workerMaterialsRepo;
    
    /** @var OrderMaterialsRepo */
    private $orderMaterialsRepo;
    
    public function __construct()
    {
        $this->orderRepo = app('OrderRepo');
        $this->workerRepo = app('WorkerRepo');
        
        $this->workerMaterialsRepo = app('WorkerMaterialsRepo');
        $this->orderMaterialsRepo = app('OrderMaterialsRepo');
    }

    public function stockMaterial($worker_id, $order_id, $code)
    {
        /** @var OrderService $orderService */
        $orderService = app('OrderService'); // new OrderService($this->orderRepo);


        $orderMaterial = $this->orderRepo->findMaterialBy($order_id, $code);
        
        $needMaterialAmount = $orderMaterial->need - $orderMaterial->stock;  
        
        
        $decrementMaterial = new DecrementMaterial($worker_id, $code, $needMaterialAmount);

        $stockMaterial = new StockMaterial($orderMaterial, $needMaterialAmount);



        Bus::dispatch($decrementMaterial);

        Bus::dispatch($stockMaterial);




        // as event-callback
        $orderService->checkStatusAfterStockMaterial($order_id);
    }

    public function takeReward($order_id, $worker_id)
    {
//        $heroRepo = app('HeroRepo');
        
        $order = $this->orderRepo->find($order_id);

        
        $incrementGold = new IncrementGold($worker_id, $order->price);

        Bus::dispatch($incrementGold);
    }


}
