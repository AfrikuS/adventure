<?php

namespace App\Modules\Work\Controllers\Order;

use App\Models\Work\Worker;
use App\Modules\Work\Commands\Order\CreateBuildOrderAction;
use App\Modules\Work\Controllers\WorkController;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Input;

class OrdersController extends WorkController
{
    public function index()
    {
        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');


        $freeOrders = $ordersRepo->getFreeOrders();

        $workerOrders = $ordersRepo->getAcceptedOrders($this->user_id);

        return $this->view('work.order.orders_index', [
            'orders' => $freeOrders,
            'workerOrders' => $workerOrders,
        ]);
    }

    public function generateOrder()
    {
        $customer_id = $this->user_id;
        $reward = 400;
        $type = 'gates-s-s-s-s';

        $cmd = new CreateBuildOrderAction();

        $cmd->createBuildOrder($customer_id, $type, $reward);



        return \Redirect::route('work_orders_page');
    }
}
