<?php

namespace App\Http\Controllers\Work\Team;

use App\Commands\Work\TeamOrder\AcceptTeamOrderCommand;
use App\Commands\Work\TeamOrder\AddMaterialTeamOrderCommand;
use App\Commands\Work\TeamOrder\ApplySkillTeamOrderCommand;
use App\Commands\Work\TeamOrder\DeleteTeamOrderCommand;
use App\Commands\Work\TeamOrder\EstimateTeamOrderCommand;
use App\Commands\Work\TeamOrder\TakeRewardTeamOrderCommand;
use App\Exceptions\DefecitMaterialException;
use App\Exceptions\NotTeamLeaderException;
use App\Exceptions\WorkerWithoutTeamException;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Work\Team\TeamOrder;
use App\Models\Work\Worker;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\StateMachines\Work\TeamOrderEntity;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TeamOrderController extends Controller
{
    /** @var TeamOrderRepositoryObj */
    protected $teamOrdersRep;
    /** @var WorkerRepositoryObj */
    protected $workerRep;

    public function __construct(TeamOrderRepositoryObj $teamOrdersRep, WorkerRepositoryObj $workerRep)
    {
        $this->teamOrdersRep = $teamOrdersRep;
        $this->workerRep = $workerRep;
        parent::__construct();
    }

    public function index()
    {
        $worker_id = \Auth::id();

        $orders = TeamOrder::
            select('id', 'desc', 'kind_work', 'price', 'acceptor_team_id', 'status')
            ->where('status', 'free')
            ->get();

        $worker = $this->workerRep->findWithTeamById($worker_id); // WorkerRepository::findById();

        $userTeamOrders = $worker->team->orders; // TeamOrderRepository::getTeamOrders($worker->team);

        return $this->view('work.teamorder.orders_index', [
            'orders' => $orders,
            'userTeamOrders' => $userTeamOrders,
        ]);
    }

    public function showOrder($id)
    {
        /** @var Worker $worker*/
        $worker = $this->workerRep->findWithMaterialsAndSkillsById(\Auth::id());
        /** @var TeamOrderEntity $order */
        $order = $this->teamOrdersRep->findOrderWithMaterialsAndSkillsById($id);


        switch ($order->status) {
            case 'accepted':

                return $this->view('work.teamorder.show.accepted', [
                    'order' => $order,
                ]);

            case 'stock_materials':

                $orderMaterials = $order->materials;
                $workerNeedMaterials = $this->workerRep->selectWorkerMaterialsNeedForOrder($order, $worker);

                return $this->view('work.teamorder.show.stock_materials', [
                    'order' => $order,
                    'orderMaterials' => $orderMaterials,
                    'userMaterials' => $workerNeedMaterials,
                ]);

            case 'stock_skills':

                $orderSkills = $order->skills;
                $userSkills = $worker->skills;

                return $this->view('work.teamorder.show.stock_skills', [
                    'order' => $order,
                    'orderSkills' => $orderSkills,
                    'userSkills' => $userSkills,
                ]);

            case 'completed':

                return $this->view('work.teamorder.show.completed', [
                    'order' => $order,
                ]);
        }

        throw new \Exception; // UnknownTeamOrderStatus
    }

    public function acceptOrder()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $user_id = \Auth::id();


        try {
            $cmd = new AcceptTeamOrderCommand($this->teamOrdersRep, $this->workerRep);

            $cmd->acceptTeamOrder($order_id, $user_id);
        }
        catch (WorkerWithoutTeamException $e)
        {
            Session::flash('message', 'Worker without team cannot accept team-order');
            return \Redirect::back();
        }
        catch (NotTeamLeaderException $e)
        {
            Session::flash('message', 'Only Team-Leader can accept team-order');
            return \Redirect::back();
        }

        return Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }

    public function estimate()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();

        $cmd = new EstimateTeamOrderCommand($this->teamOrdersRep, $this->workerRep);

        $cmd->estimateTeamOrder($order_id, $worker_id);

        return Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }
    
    public function addMaterial()
    {
        $data = Input::all();

        $materialCode = $data['material'];
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();

        try {
            $cmd = new AddMaterialTeamOrderCommand($this->teamOrdersRep, $this->workerRep);

            $cmd->addMaterial($order_id, $worker_id, $materialCode);
        }
        catch (DefecitMaterialException $e)
        {
            Session::flash('message', 'Nedostatochno ' . $materialCode);
            return Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
        }


        Session::flash('message', 'Stocked ' . $materialCode);

        return Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }

    public function applySkill()
    {
        $data = Input::all();

        $skillCode = $data['skill'];
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();

        $cmd = new ApplySkillTeamOrderCommand($this->teamOrdersRep, $this->workerRep);

        $cmd->applySkill($order_id, $worker_id, $skillCode);


        Session::flash('message', 'Applyed ' . $skillCode);

        return Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }

    public function takeReward()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();


        $cmd = new TakeRewardTeamOrderCommand($this->teamOrdersRep, $this->workerRep, new HeroRepositoryObj());
        
        $cmd->takeReward($order_id, $worker_id);

        
        
        return Redirect::route('work_teamorders_page');
    }

    public function deleteTeamOrder($id)
    {
        $cmd = new DeleteTeamOrderCommand($this->teamOrdersRep);
        $cmd->deleteTeamOrder($id);

        return redirect()->route('work_teamorders_page');
    }
}
