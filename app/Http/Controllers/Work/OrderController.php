<?php

namespace App\Http\Controllers\Work;

use App\Domain\Work\MaterialsActions;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\UserMaterial;
use App\Models\Work\Catalogs\Skill;
use App\Models\Work\Worker;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerMaterialsRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\SkillRepository;
use App\StateMachines\Work\OrderStateMachine;
use App\Transactions\Work\OrderTransactions;
use App\ViewModel\WorkViewModels;
use Finite\Exception\StateException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $freeOrders = Order::where('status', 'free')->get();
        $workerOrders = WorkerRepository::getSingleOrders(\Auth::id());

        return $this->view('work.order.orders_index', [
            'orders' => $freeOrders,
            'workerOrders' => $workerOrders,
        ]);
    }

    public function acceptOrder()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $user_id = \Auth::id();

        $order = OrderRepository::findOnlyOrderById($order_id);
        $orderSM = new OrderStateMachine($order);

        $orderSM->accept($user_id);

        return Redirect::route('work_show_order_page', ['id' => $order->id]);
    }

    public function showOrder(Request $request, $id)
    {
        /** @var Worker $worker*/
        $worker = $request->get('worker');
        if ($worker === null) {
            $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        }

        /** @var Order $order */
        $order = $request->get('order');
        if ($order === null) {
            $order = OrderRepository::findOrderWithMateriaslAndSkillsById($id);
        }

        $orderMaterials = $order->materials;

        $orderReadyToBeginWorks = OrderRepository::isOrderReadyToWorks($order);

        $workerNeedMaterials = WorkViewModels::getWorkerMaterialsNeedForOrder($order, $worker);

        return $this->view('work.order.show_order', [
            'order' => $order,
            'orderMaterials' => $orderMaterials,
            'userMaterials' => $workerNeedMaterials,
            'orderReady' => $orderReadyToBeginWorks,
        ]);
    }

    public function addMaterial()
    {
        $data = Input::all();
        $materialCode = $data['material'];
        $order_id = $data['order_id'];

        /** @var Order $order */
        $order = OrderRepository::findOrderWithMateriaslAndSkillsById($order_id);
        $orderState = new OrderStateMachine($order);

        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        
        if (!OrderRepository::hasWorkerNeedAmountMaterialForOrder($worker, $order, $materialCode)) {
        
            Session::flash('message', 'Nedostatochno ' . $materialCode);
            return redirect()->back();
        }

        OrderTransactions::transferMaterialFromWorkerToOrder($worker, $order, $materialCode);

        if ($orderState->areMaterialsStocked()) {
            $orderState->finishStockMaterials();
            Session::flash('message', 'All materials are stocked');
        }

        Session::flash('message', 'Stocked ' . $materialCode);

        return Redirect::route('work_show_order_page', ['id' => $order->id]);
    }

    public function applySkill()
    {
        $data = Input::all();
        $order_id = $data['order_id'];

        $order = OrderRepository::findOnlyOrderById($order_id);
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());

        $orderState = new OrderStateMachine($order);
        $orderState->finishStockSkills($worker);

        return Redirect::route('work_show_order_page', ['id' => $order->id]);
    }
}
