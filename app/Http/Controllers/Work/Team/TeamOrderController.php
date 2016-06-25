<?php

namespace App\Http\Controllers\Work\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Team\PrivateTeam;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Worker;
use App\Repositories\Work\PrivateTeamRepository;
use App\Repositories\Work\SkillRepository;
use App\Repositories\Work\Team\TeamOrderMaterialRepository;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\TeamOrderSkillRepository;
use App\Repositories\Work\Team\WorkerRepository;
use App\Repositories\Work\WorkerMaterialsRepository;
use App\Transactions\Work\Team\TeamOrderTransactions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TeamOrderController extends Controller
{
    public function index()
    {
        $orders = TeamOrder::
            select('id', 'desc', 'kind_work', 'price', 'acceptor_team_id', 'status')
            ->where('status', 'free')
            ->get();

        $worker = WorkerRepository::findById(\Auth::id());

        $userTeamOrders = TeamOrderRepository::getTeamOrders($worker->team);


//        $worker->team->orders;;

        return $this->view('work.teamorder.orders_index', [
            'orders' => $orders,
            'userTeamOrders' => $userTeamOrders,
        ]);
    }

    public function showOrder($id)
    {
        $order = TeamOrderRepository::getOrderWithMaterialsAndSkillsById($id);
        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());

        if ($order->status == 'stock_materials') {

//            $userMaterials = $worker->materials;
            $orderMaterialsCodes = $order->materials()->select('code')->get()->lists('code')->toArray();

            $userMaterials = $worker->materials()->whereIn('code', $orderMaterialsCodes)->get();

            return $this->view('work.teamorder.order_state.order_stock_materials', [
                'order' => $order,
                'orderMaterials' => $order->materials,
                'userMaterials' => $userMaterials,
            ]);
        }
        elseif ($order->status == 'stock_skills') {

            $orderSkills = $order->skills;
            $userSkills = $worker->skills;

            return $this->view('work.teamorder.order_state.order_stock_skills', [
                'order' => $order,
                'orderSkills' => $orderSkills,
                'userSkills' => $userSkills,
            ]);
        }
        elseif ($order->status == 'completed') {

            return $this->view('work.teamorder.order_state.order_completed', [
                'order' => $order,
            ]);
        }


        return $this->view('work.teamorder.show_order', [
            'order' => $order,
            'orderMaterials' => $order->materials,
//            'userMaterials' => $userMaterials,
//            'orderSkills' => $orderSkills,
//            'userSkills' => $userSkills,
        ]);
    }

    public function acceptOrder()
    {
        $data = Input::all();
        $order_id = $data['order_id'];

        $order = TeamOrderRepository::getOrderById($order_id);
        $worker = WorkerRepository::findById(\Auth::id());

        $team = $worker->team;

        // заказ может принимать только лидер? -> да(проверка в мидлваре)
        $order->acceptor_team_id = $team->id;


        $order->status = 'stock_materials';
        $order->save();

        return Redirect::route('work_show_teamorder_page', ['id' => $order->id]);
    }

    public function addMaterial()
    {
        $data = Input::all();

        $materialCode = $data['material'];
        $order_id = $data['order_id'];

        $worker = WorkerRepository::findById(\Auth::id());
        $order = TeamOrderRepository::getOrderWithMaterialsAndSkillsById($order_id);

        // validate  $orderMaterial != null
        // validate

        if (!WorkerRepository::hasAmountMaterialForOrder($worker, $order, $materialCode)) {

            Session::flash('message', 'Nedostatochno ' . $materialCode);
            return Redirect::route('work_show_teamorder_page', ['id' => $order->id]);
        }

        // action
        TeamOrderTransactions::transferMaterialFromUserToOrder($worker, $order, $materialCode);
//        TeamOrderMaterialRepository::deleteStockedMaterial($orderMaterial);

        if (TeamOrderRepository::isFinishedStockMaterials($order)) {
            // orderState->apply(finish_stock_materials)
            $order->update(['status' => 'stock_skills']);
        }

        Session::flash('message', 'Внесено ' . $materialCode);
        return Redirect::route('work_show_teamorder_page', ['id' => $order->id]);
    }

    public function addSkill()
    {
        $data = Input::all();

        $skillCode = $data['skill'];
        $order_id = $data['order_id'];

        $worker = WorkerRepository::findWithMaterialsAndSkillsById(\Auth::id());
        $order = TeamOrderRepository::getOrderById($order_id);


        TeamOrderTransactions::applySkillToOrder($worker, $order, $skillCode);
        Session::flash('message', 'Применен навык ' . $skillCode);

        if (TeamOrderRepository::isFinishedStockSkills($order)) {
            $order->update(['status' => 'completed']);
        }

        // midlewareAfter order_actions => actions if order->completed

        return Redirect::route('work_show_teamorder_page', ['id' => $order->id]);
    }
}
