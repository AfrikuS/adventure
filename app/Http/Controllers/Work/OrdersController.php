<?php

namespace App\Http\Controllers\Work;

use App\Http\Requests;
use App\Models\Work\Worker;
use App\Repositories\Work\OrdersRepository;
use App\Repositories\Work\WorkerRepositoryObj;

class OrdersController extends WorkController
{
    /** @var OrdersRepository */
    protected $ordersRepo;

    public function __construct(OrdersRepository $ordersRepo, WorkerRepositoryObj $workerRepo)
    {
        $this->ordersRepo = $ordersRepo;

        parent::__construct($workerRepo);
    }

    public function index()
    {
        $freeOrders = $this->ordersRepo->getFreeOrders();

        $workerOrders = $this->ordersRepo->getAcceptedOrders($this->worker->id);

        return $this->view('work.order.orders_index', [
            'orders' => $freeOrders,
            'workerOrders' => $workerOrders,
        ]);
    }
}
