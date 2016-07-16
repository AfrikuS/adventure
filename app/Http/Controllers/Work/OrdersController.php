<?php

namespace App\Http\Controllers\Work;

use App\Commands\Work\IndividualOrder\DeleteOrderCommand;
use App\Http\Requests;
use App\Models\Work\Worker;
use App\Repositories\Generate\EntityGenerator;
use App\Repositories\OrdersRepository;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class OrdersController extends WorkController
{
    /** @var OrderRepositoryObj */
    protected $ordersRepo;

    public function __construct(OrdersRepository $ordersRepo, WorkerRepositoryObj $workerRep)
    {
        $this->ordersRepo = $ordersRepo;

        parent::__construct($workerRep);
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



    public function acceptOrder()
    {
        $data = Input::all();
        $order_id = $data['order_id'];

        
        $orderEntity = $this->ordersRepo->findSimpleOrderById($order_id);

        $orderEntity->accept($this->worker->id);

        return Redirect::route('work_show_order_page', ['id' => $orderEntity->id]);
    }

    
    public function deleteOrder($id)
    {
        
        $cmd = new DeleteOrderCommand($this->ordersRepo);
        
        $cmd->deleteOrder($id);
        
        return redirect()->route('work_orders_page');
    }
    
    public function generateOrder()
    {
        EntityGenerator::createWorkOrderWithMaterials();

        return redirect()->route('work_orders_page');
    }

}
