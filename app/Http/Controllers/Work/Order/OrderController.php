<?php

namespace App\Http\Controllers\Work\Order;

use App\Commands\Hero\UpBuildingLevelCmd;
use App\Commands\Work\IndividualOrder\AcceptOrderCommand;
use App\Commands\Work\IndividualOrder\AddMaterialCommand;
use App\Commands\Work\IndividualOrder\DeleteOrderCommand;
use App\Commands\Work\IndividualOrder\EstimateOrderCommand;
use App\Commands\Work\IndividualOrder\GenerateOrderCommand;
use App\Commands\Work\IndividualOrder\TakeRewardCommand;
use App\Entities\Work\OrderEntity;
use App\Exceptions\NotEnoughMaterialException;
use App\Http\Controllers\Work\WorkController;
use App\Models\Work\Catalogs\Material;
use App\Models\Work\Worker;
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
        /** @var OrderEntity $order */
        $order = $this->orderRepo->findOrderWithMaterialsById($id);


        switch ($order->status) 
        {
            case 'accepted':

                return $this->view('work.order.show.accepted', [
                    'order' => $order,
                ]);

            case 'stock_materials':

                $orderMaterials = $order->materials;
                $workerNeedMaterials = $this->workerRepo->selectWorkerMaterialsNeedForOrder($order, $this->worker);

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


        $cmd = new AcceptOrderCommand($this->orderRepo);

        $cmd->accept($order_id, $this->worker);


        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }


    public function estimate()
    {
        $data = Input::all();
        $order_id = $data['order_id'];

        // -----------
        $faker = \Faker\Factory::create();

        $materialsCodes = Material::get(['id', 'code'])->pluck('code');

        for ($i = 0; $i < 2; $i++) { // wtf todo
            $materialCode = $faker->unique()->randomElement($materialsCodes->toArray());

            $this->orderRepo->createMaterial($order_id, $materialCode, $need = 2);
        }
//        if ($order->desc == 'gates') {










        // -----------

        $cmd = new EstimateOrderCommand($this->orderRepo, $this->workerRepo);

        $cmd->estimateOrder($order_id, $this->worker->id);
        
        
        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }


    public function stockMaterial()
    {
        $data = Input::all();

        $materialCode = $data['material'];
        $order_id = $data['order_id'];

        try {
            $cmd = new AddMaterialCommand($this->orderRepo, $this->workerRepo);

            $cmd->addMaterial($order_id, $this->worker->id, $materialCode);
        }
        catch (NotEnoughMaterialException $e)
        {
            Session::flash('message', 'Nedostatochno ' . $materialCode);
        }


        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function applySkill()
    {
        $data = Input::all();

        $order_id = $data['order_id'];

        $repo = new OrderRepositoryObj();
        $order = $repo->findSimpleOrderById($order_id);
        

        
        

        $cmd = new TakeRewardCommand($this->orderRepo, $this->workerRepo, new HeroRepositoryObj());
        
        $cmd->takeReward($order_id, $this->worker->id);

        $cmd = new UpBuildingLevelCmd();
        $cmd->upBuildingLevel($order->customer_hero_id, $order->desc);


        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function takeReward()
    {
        
    }

    public function delete()
    {
        $data = Input::all();

        $order_id = $data['order_id'];


        $cmd = new DeleteOrderCommand($this->orderRepo);

        $cmd->deleteOrder($order_id);


        return \Redirect::route('work_orders_page');
    }

    public function generate()
    {
        $cmd = new GenerateOrderCommand($this->orderRepo);

        $cmd->generateOrder();


        return \Redirect::route('work_orders_page');
    }
}
