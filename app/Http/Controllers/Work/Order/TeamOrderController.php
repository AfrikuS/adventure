<?php

namespace App\Http\Controllers\Work\Order;

use App\Commands\Work\TeamOrder\AcceptTeamOrderCommand;
use App\Commands\Work\TeamOrder\AddMaterialTeamOrderCommand;
use App\Commands\Work\TeamOrder\ApplySkillTeamOrderCommand;
use App\Commands\Work\TeamOrder\DeleteTeamOrderCommand;
use App\Commands\Work\TeamOrder\EstimateTeamOrderCommand;
use App\Commands\Work\TeamOrder\TakeRewardTeamOrderCommand;
use App\Entities\Work\TeamOrderEntity;
use App\Exceptions\DefecitMaterialException;
use App\Exceptions\NotTeamLeaderException;
use App\Exceptions\WorkerWithoutTeamException;
use App\Http\Controllers\Work\WorkController;
use App\Http\Requests;
use App\Models\Work\Worker;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Security\TeamOrderSecurity;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TeamOrderController extends WorkController
{
    /** @var TeamOrderRepositoryObj */
    protected $teamOrderRepo;

    public function __construct(TeamOrderRepositoryObj $teamOrderRepo, WorkerRepositoryObj $workerRepo)
    {
        parent::__construct($workerRepo);

        $this->teamOrderRepo = $teamOrderRepo;
    }


    public function index($id)
    {
        /** @var TeamOrderEntity $order */
        $order = $this->teamOrderRepo->findOrderWithMaterialsAndSkillsById($id);

        switch ($order->status) 
        {
            case 'accepted':

                return $this->view('work.teamorder.show.accepted', [
                    'order' => $order,
                ]);

            case 'stock_materials':

                $orderMaterials = $order->materials;
                $workerNeedMaterials = $this->workerRepo->selectWorkerMaterialsNeedForOrder($order, $this->worker);

                return $this->view('work.teamorder.show.stock_materials', [
                    'order' => $order,
                    'orderMaterials' => $orderMaterials,
                    'userMaterials' => $workerNeedMaterials,
                ]);

            case 'stock_skills':

                $orderSkills = $order->skills;
                $userSkills = $this->worker->skills;

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


        try {

            $cmd = new AcceptTeamOrderCommand($this->teamOrderRepo, $this->workerRepo);

            $cmd->acceptTeamOrder($order_id, $this->worker->id);
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

        return \Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }


    public function estimate()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();

        $cmd = new EstimateTeamOrderCommand($this->teamOrderRepo, $this->workerRepo);

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
            $cmd = new AddMaterialTeamOrderCommand($this->teamOrderRepo, $this->workerRepo);

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

        $cmd = new ApplySkillTeamOrderCommand($this->teamOrderRepo, $this->workerRepo);

        $cmd->applySkill($order_id, $worker_id, $skillCode);


        Session::flash('message', 'Applyed ' . $skillCode);

        return Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }

    public function takeReward()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $worker_id = \Auth::id();


        $cmd = new TakeRewardTeamOrderCommand($this->teamOrderRepo, $this->workerRepo, new HeroRepositoryObj());
        
        $cmd->takeReward($order_id, $worker_id);

        
        
        return Redirect::route('work_teamorders_page');
    }

    public function delete($id)
    {
        $cmd = new DeleteTeamOrderCommand($this->teamOrderRepo);

        $cmd->deleteTeamOrder($id);

        return redirect()->route('work_teamorders_page');
    }

}
