<?php

namespace App\Modules\Work\Controllers\Order;

use App\Models\Work\Worker;
use App\Modules\Work\Commands\Order\CreateBuildOrderCommand;
use App\Modules\Work\Controllers\WorkController;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Input;

class OrdersController extends WorkController
{
    /** @var OrderRepo */
    protected $ordersRepo;

    public function __construct(WorkerRepositoryObj $workerRepo)
    {
        $this->ordersRepo = app('OrderRepo');//$ordersRepo;

        parent::__construct($workerRepo);
    }

    public function index()
    {
        $freeOrders = $this->ordersRepo->getFreeOrders();

        $workerOrders = $this->ordersRepo->getAcceptedOrders($this->user_id);

        return $this->view('work.order.orders_index', [
            'orders' => $freeOrders,
            'workerOrders' => $workerOrders,
        ]);
    }

    public function generateOrder()
    {
        $data = Input::all();

//        $this->dispatch(new SendMessageToWorker(\Auth::id()));

        $customer_id = $this->user_id;
        $reward = 400;
        $type = 'gates-s-s-s-s';

        $cmd = new CreateBuildOrderCommand();

        $cmd->createBuildOrder($customer_id, $type, $reward);



        return \Redirect::route('work_orders_page');
    }
}
