<?php

namespace App\Http\Controllers\Work\Order;

use App\Commands\Hero\UpBuildingLevelCmd;
use App\Commands\Work\IndividualOrder\AcceptOrderCommand;
use App\Commands\Work\IndividualOrder\AddMaterialCommand;
use App\Commands\Work\IndividualOrder\DeleteOrderCommand;
use App\Commands\Work\IndividualOrder\EstimateOrderCommand;
use App\Commands\Work\IndividualOrder\GenerateOrderCommand;
use App\Commands\Work\IndividualOrder\TakeRewardCommand;
use App\Commands\Work\Order\Actions\ApplySkill;
use App\Commands\Work\Order\Actions\CancelApplySkill;
use App\Entities\Work\OrderEntity;
use App\Exceptions\NotEnoughMaterialException;
use App\Http\Controllers\Work\WorkController;
use App\Infrastructure\IdentityMap;
use App\Lib\Work\OrderBuilder;
use App\Lib\Work\OrderMaterialsGenerator;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Worker;
use App\Persistence\Repositories\Work\Catalogs\MaterialsRepo;
use App\Persistence\Repositories\Work\OrderMaterialsRepo;
use App\Persistence\Repositories\Work\OrderRepo;
use App\Persistence\Repositories\Work\WorkerRepo;
use App\Repositories\HeroRepositoryObj;
use App\Repositories\Work\OrderRepositoryObj;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class OrderController extends WorkController
{
    /** @var OrderRepositoryObj */
    protected $orderRepo;

    public function __construct(OrderRepositoryObj $orderRepo)
    {
        parent::__construct(new WorkerRepositoryObj());
        
        $this->orderRepo = $orderRepo;
    }

    public function index($id)
    {
//        /** @var OrderEntity $order */
//        $order = $this->orderRepo->findOrderWithMaterialsById($id);

        $orderRepoNew = new OrderRepo();

        $order = $orderRepoNew->findOrderWithMaterialsById($id);


        switch ($order->status) 
        {
            case 'accepted':

                return $this->view('work.order.show.accepted', [
                    'order' => $order,
                ]);

            case 'stock_materials':

                $orderMaterials = $order->materials;
                $viewOrderMaterials = $order->materials->extract();

                $workerRepo = new WorkerRepo();
                $worker = $workerRepo->getWithMaterialsByUser($this->user_id);
                $workerMaterials = $worker->materials;




//                $workerNeedMaterials = $this->workerRepo->selectWorkerMaterialsNeedForOrder($order, $this->worker);
                $workerNeedMaterials = $orderMaterials->selectIntersect($workerMaterials);

                return $this->view('work.order.show.stock_materials', [
                    'order' => $order,
                    'orderMaterials' => $viewOrderMaterials,
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

            default:

                // order not accepted, free
                Session::flash('message', 'It\'s not your order');
                return \Redirect::route('work_orders_page');
        }
    }

    public function accept()
    {
        $data = Input::all();
        $order_id = $data['order_id'];


        $cmd = new AcceptOrderCommand();

        $cmd->acceptOrder($order_id, $this->user_id);


        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }


    public function estimate(MaterialsRepo $materialsRepo,
                             OrderMaterialsRepo $orderMaterialsRepo,
                             OrderRepo $orderRepo
    )
    {
        $data = Input::all();
        $order_id = $data['order_id'];




        $cmd = new EstimateOrderCommand($materialsRepo, $orderMaterialsRepo, $orderRepo);

        $cmd->estimateOrder($order_id, $this->worker->id);
        
        
        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }


    public function stockMaterial(OrderRepo $orderRepo, WorkerRepo $workerRepo)
    {
        $data = Input::all();

        $materialCode = $data['material'];
        $order_id = $data['order_id'];

        try 
        {

            $cmd = new AddMaterialCommand($orderRepo, $workerRepo);

            $cmd->addMaterial($order_id, $materialCode, $this->worker->id);

        }
        catch (NotEnoughMaterialException $e)
        {
            Session::flash('message', 'Nedostatochno ' . $materialCode);
        }


        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function applySkill(OrderRepo $orderRepo, WorkerRepo $workerRepo)
    {
        $data = Input::all();

        $order_id = $data['order_id'];

        $cmd = new ApplySkill($orderRepo, $workerRepo);

        $cmd->applySkill($order_id, $this->worker->id);



        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function cancelSkill(OrderRepo $orderRepo)
    {
        $data = Input::all();

        $order_id = $data['order_id'];

        $cmd = new CancelApplySkill($orderRepo);

        $cmd->cancel($order_id);




        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }
    
    public function takeReward()
    {
        
    }

    public function delete(OrderRepo $orderRepo)
    {
        $data = Input::all();

        $order_id = $data['order_id'];


        $cmd = new DeleteOrderCommand($orderRepo);

        $cmd->deleteOrder($order_id);


        return \Redirect::route('work_orders_page');
    }

    public function generate(MaterialsRepo $materialsRepo,
                             OrderMaterialsRepo $orderMaterialsRepo,
                             OrderRepo $orderRepo
    )
    {
        $cmd = new GenerateOrderCommand($materialsRepo, $orderMaterialsRepo, $orderRepo);

        $cmd->generateOrder($this->user_id);


        return \Redirect::route('work_orders_page');
    }
}
