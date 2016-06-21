<?php

namespace App\Http\Controllers\Work;

use App\Domain\Work\MaterialsActions;
use App\Models\Work\Order;
use App\Models\Work\OrderMaterials;
use App\Models\Work\UserMaterial;
use App\Models\Work\WorkSkill;
use App\Repositories\HeroResourcesRepository;
use App\Repositories\Work\UserMaterialsRepository;
use App\Repositories\Work\OrderMaterialsRepository;
use App\Repositories\Work\OrderRepository;
use App\Repositories\Work\SkillRepository;
use App\Transactions\Work\OrderTransactions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::get();

        return $this->view('work/order/orders_index', [
            'orders' => $orders,
        ]);
    }

    public function showOrder($id)
    {
        $order = OrderRepository::getOrderById($id);

        $orderMaterials = OrderMaterialsRepository::getOrderMaterials($order);

        $orderReadyToBeginWorks = OrderRepository::isOrderReadyToWorks($order);

        $userMaterials = UserMaterialsRepository::getMaterialsSameOrder(auth()->user(), $order);

        return $this->view('work/order/show_order', [
            'order' => $order,
            'orderMaterials' => $orderMaterials,
            'userMaterials' => $userMaterials,
            'orderReady' => $orderReadyToBeginWorks,
        ]);
    }

    public function addMaterial()
    {
        $data = Input::all();

        $materialCode = $data['material'];
        $order_id = $data['order_id'];

        $order = OrderRepository::getOrderById($order_id);
        $orderMaterial = OrderMaterialsRepository::getOrderMaterialByCode($order, $materialCode);
        

        // validate
        if (!UserMaterialsRepository::hasUserNeedMaterialAmount(auth()->user(), $orderMaterial)) {
        
            Session::flash('message', 'Nedostatochno ' . $orderMaterial->code);
            return redirect()->back();
        }

        // action
        OrderTransactions::transferMaterialFromUserToOrder(auth()->user(), $orderMaterial);
        OrderMaterialsRepository::deleteStockedMaterial($orderMaterial);

        // validate
        if (OrderRepository::orderReadyToWork($order)) {
            // action
            $order->update(['status' => 'ready_to_work']);
        }

        Session::flash('message', 'Внесено ' . $materialCode);

        return redirect()->back();
    }

    public function startWorks()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $order = OrderRepository::getOrderById($order_id);
        
        OrderRepository::startWorks($order);

        OrderTransactions::transferOrderRewardToUser($order, auth()->user());

        OrderRepository::finishWorks($order);
//      OrderMaterialsRepository::deleteOrder($order);

        return redirect()->back();
    }
}
