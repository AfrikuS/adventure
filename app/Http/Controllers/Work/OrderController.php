<?php

namespace App\Http\Controllers\Work;

use App\Commands\Work\IndividualOrder\AddMaterialCommand;
use App\Commands\Work\IndividualOrder\DeleteOrderCommand;
use App\Commands\Work\IndividualOrder\EstimateOrderCommand;
use App\Commands\Work\IndividualOrder\TakeRewardCommand;
use App\Deleters\WorkDeleter;
use App\Exceptions\DefecitMaterialException;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Worker;
use App\Repositories\Generate\EntityGenerator;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Entities\Work\OrderEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Config\Definition\Exception\Exception;

class OrderController extends AppController
{
    /** @var OrderRepositoryObj */
    protected $ordersRep;

    public function __construct(OrderRepositoryObj $teamOrdersRep, WorkerRepositoryObj $workerRep)
    {
        $this->ordersRep = $teamOrdersRep;

        parent::__construct($workerRep);
    }

    public function index()
    {
        $freeOrders = $this->ordersRep->getFreeOrders();

        $workerOrders = $this->workerRep->getAcceptedOrders(\Auth::id());

//        $ch = $workerOrders->chunk(2);

        return $this->view('work.order.orders_index', [
            'orders' => $freeOrders,
            'workerOrders' => $workerOrders,
        ]);
    }

    public function showOrder(Request $request, $id)
    {
        /** @var Worker $worker*/
        // worker_load_materials_and_skills
        $worker = $this->workerRep->findWithMaterialsAndSkillsById(\Auth::id());
        /** @var OrderEntity $order */
        $order = $this->ordersRep->findOrderWithMaterialsById($id);


        switch ($order->status) {
            case 'accepted':

                return $this->view('work.order.show.accepted', [
                    'order' => $order,
                ]);
            
            case 'stock_materials':

                $orderMaterials = $order->materials;
                $workerNeedMaterials = $this->workerRep->selectWorkerMaterialsNeedForOrder($order, $worker);

                return $this->view('work.order.show.stock_materials', [
                    'order' => $order,
                    'orderMaterials' => $orderMaterials,
                    'userMaterials' => $workerNeedMaterials,
                ]);
            
            case 'stock_skills':

                return $this->view('work.order.show.stock_skills', [
                    'order' => $order,
                ]);
            
            case 'completed':
                
                return $this->view('work.order.show.completed', [
                    'order' => $order,
                ]);
        }

        // order not accepted, free
        throw new Exception;
    }

    public function acceptOrder()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $user_id = \Auth::id();

        $orderEntity = $this->ordersRep->findSimpleOrderById($order_id);

        $orderEntity->accept($user_id);

        return Redirect::route('work_show_order_page', ['id' => $orderEntity->id]);
    }

    public function addMaterial()
    {
        $data = Input::all();
        $materialCode = $data['material'];
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();

        try {
            $cmd = new AddMaterialCommand($this->ordersRep, $this->workerRep);
        
            $cmd->addMaterial($order_id, $worker_id, $materialCode);
        }
        catch (DefecitMaterialException $e)
        {
            Session::flash('message', 'Nedostatochno ' . $materialCode);
            return Redirect::route('work_show_order_page', ['id' => $order_id]);
        }
        

        Session::flash('message', 'Stocked ' . $materialCode);

        return Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function applySkill()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();


        $cmd = new TakeRewardCommand($this->ordersRep, $this->workerRep, new HeroRepositoryObj());
        $cmd->takeReward($order_id, $worker_id);
        
        return Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function deleteOrder($id)
    {
//        WorkDeleter::deleteOrder($id);
        
        $cmd = new DeleteOrderCommand($this->ordersRep);
        
        $cmd->deleteOrder($id);
        
        return redirect()->route('work_orders_page');
    }

    public function estimate()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();

        $cmd = new EstimateOrderCommand($this->ordersRep, $this->workerRep);

        $cmd->estimateOrder($order_id, $worker_id);

        return Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function generateOrder()
    {
        EntityGenerator::createWorkOrderWithMaterials();
        return redirect()->route('work_orders_page');
    }

}
