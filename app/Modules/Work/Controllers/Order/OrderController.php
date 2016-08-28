<?php

namespace App\Modules\Work\Controllers\Order;

use App\Exceptions\NotEnoughMaterialException;
use App\Models\Work\Worker;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use App\Modules\Work\Commands\Order\AcceptOrderCommand;
use App\Modules\Work\Commands\Order\ApplySkill;
use App\Modules\Work\Commands\Order\CancelApplySkill;
use App\Modules\Work\Commands\Order\DeleteOrderCommand;
use App\Modules\Work\Commands\Order\EstimateOrderCommand;
use App\Modules\Work\Commands\Order\GenerateOrderCommand;
use App\Modules\Work\Commands\Order\StockMaterialCommand;
use App\Modules\Work\Controllers\WorkController;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Persistence\Repositories\Order\OrderRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class OrderController extends WorkController
{
    /** @var OrderRepo */
    protected $orderRepo;

    public function __construct()
    {
        parent::__construct();
        
        $this->orderRepo = app('OrderRepo'); // $orderRepo;
    }

    public function index($id)
    {
//        /** @var OrderEntity $order */
//        $order = $this->orderRepo->findOrderWithMaterialsById($id);

        /** @var OrderRepo $orderRepoNew */
        $orderRepoNew = app('OrderRepo'); // new OrderRepo();

        $order = $orderRepoNew->findOrderWithMaterialsById($id);


        switch ($order->status) {

            case Order::STATUS_ACCEPTED:


/*                if ($order->haveAcceptor() && ($order->acceptor_worker_id == $user_id)) {
                    return true;
                }
*/
                return $this->view('work.order.show.accepted', [
                    'order' => $order,
                ]);

            case Order::STATUS_STOCK_MATERIALS:

                $orderMaterials = $order->materials;
                $viewOrderMaterials = $order->materials->extract();

                /** @var WorkerRepo $workerRepo */
                $workerRepo = app('WorkerRepo');
                $worker = $workerRepo->getWithMaterialsByUser($this->user_id);
                $workerMaterials = $worker->materials;




//                $workerNeedMaterials = $this->workerRepo->selectWorkerMaterialsNeedForOrder($order, $this->worker);
                $workerNeedMaterials = $orderMaterials->selectIntersect($workerMaterials);

                return $this->view('work.order.show.stock_materials', [
                    'order' => $order,
                    'orderMaterials' => $viewOrderMaterials,
                    'userMaterials' => $workerNeedMaterials,
                ]);

            case Order::STATUS_STOCK_SKILLS:

                /** @var OrderSkillsRepo $skills */
                $skills = app('OrderSkillsRepo');
                $orderSkill = $skills->findSingleByOrder($id);

                $domainCode = $orderSkill->code;
                /** @var LoreRepo $loreRepo */
                $loreRepo = app('LoreRepo');

                $lore = $loreRepo->find($domainCode, $this->user_id);

                $mosaic = $lore->extractToViewDto();
                



                return $this->view('work.order.show.stock_skills', [
                    'order' => $order,
                    'mosaic' => $mosaic,
                    'orderSkill' => $orderSkill,
                ]);

            case Order::STATUS_COMPLETED:

                return $this->view('work.order.show.completed', [
                    'order' => $order,
                ]);

            case Order::STATUS_FREE:

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


    public function estimate()
    {
        $data = Input::all();
        $order_id = $data['order_id'];




        $cmd = new EstimateOrderCommand();

        $cmd->estimateOrder($order_id);
        
        
        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }


    public function stockMaterial()
    {
        $data = Input::all();

        $materialCode = $data['material'];
        $order_id = $data['order_id'];

        try 
        {

            $cmd = new StockMaterialCommand();

            $cmd->addMaterial($order_id, $materialCode, $this->user_id);

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

        $cmd = new ApplySkill();

        $cmd->applySkill($order_id, $this->user_id);



        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function cancelSkill()
    {
        $data = Input::all();

        $order_id = $data['order_id'];

        $cmd = new CancelApplySkill();

        $cmd->cancel($order_id);




        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }
    
    public function takeReward()
    {
        
    }

    public function delete()
    {
        $data = Input::all();

        $order_id = $data['order_id'];


        $cmd = new DeleteOrderCommand();

        $cmd->deleteOrder($order_id);


        return \Redirect::route('work_orders_page');
    }

    public function generate()
    {
        $cmd = new GenerateOrderCommand();

        $cmd->generateOrder($this->user_id);


        return \Redirect::route('work_orders_page');
    }
}
