<?php

namespace App\Modules\Work\Controllers\Order;

use App\Exceptions\NotEnoughMaterialException;
use App\Modules\Employment\Persistence\Repositories\DomainsRepo;
use App\Modules\Employment\Persistence\Repositories\LoreRepo;
use App\Modules\Work\Commands\Order\AcceptOrderAction;
use App\Modules\Work\Commands\Order\ApplySkillAction;
use App\Modules\Work\Commands\Order\CancelApplySkillAction;
use App\Modules\Work\Commands\Order\DeleteOrderAction;
use App\Modules\Work\Commands\Order\EstimateOrderAction;
use App\Modules\Work\Commands\Order\GenerateOrderAction;
use App\Modules\Work\Commands\Order\StockMaterialAction;
use App\Modules\Work\Controllers\WorkController;
use App\Modules\Work\Domain\Entities\Order\Order;
use App\Modules\Work\Persistence\Repositories\Order\OrdersRepo;
use App\Modules\Work\Persistence\Repositories\Order\OrderSkillsRepo;
use App\Modules\Work\Persistence\Repositories\Worker\WorkerRepo;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class OrderController extends WorkController
{
    public function index($order_id)
    {
        /** @var OrdersRepo $ordersRepo */
        $ordersRepo = app('OrdersRepo');

        $order = $ordersRepo->findOrderWithMaterialsById($order_id);


        switch ($order->status) {


            case Order::STATUS_FREE:

                Session::flash('message', 'It\'s not your order');
                return \Redirect::route('work_orders_page');


            case Order::STATUS_ACCEPTED:


                return $this->view('work.order.show.accepted', [
                    'order' => $order,
                ]);
            

            case Order::STATUS_STOCK_MATERIALS:

                $viewOrderMaterials = $order->materials;

                /** @var WorkerRepo $workerRepo */
                $workerRepo = app('WorkerRepo');


                $workerNeedMaterials = $workerRepo->getNeedMaterialsForOrder($this->user_id, $order_id);


                return $this->view('work.order.show.stock_materials', [
                    'order' => $order,
                    'orderMaterials' => $viewOrderMaterials->materials,
                    'userMaterials' => $workerNeedMaterials,
                ]);

            case Order::STATUS_STOCK_SKILLS:

                /** @var OrderSkillsRepo $skills */
                $skills = app('OrderSkillsRepo');
                $orderSkill = $skills->findBy($order_id);

                $domain_id = $orderSkill->domain_id;
                /** @var LoreRepo $loreRepo */
                $loreRepo = app('LoreRepo');

                $lore = $loreRepo->findBy($this->user_id, $domain_id);

                /** @var DomainsRepo $domainsRepo */
                $domainsRepo = app('DomainsRepo');
                
                $domain = $domainsRepo->find($order->domain_id);



                return $this->view('work.order.show.stock_skills', [
                    'order' => $order,
                    'domain' => $domain,
                    'lore' => $lore,
                    'orderSkill' => $orderSkill,
                ]);

            case Order::STATUS_COMPLETED:

                return $this->view('work.order.show.completed', [
                    'order' => $order,
                ]);
        }
    }

    public function accept()
    {
        $data = Input::all();
        $order_id = $data['order_id'];


        $cmd = new AcceptOrderAction();

        try {
            $cmd->acceptOrder($order_id, $this->user_id);
        }
        catch (StateException $e) {

            Session::flash('message', $e->getMessage());
            return \Redirect::route('work_orders_page');
        }


        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }


    public function estimate()
    {
        $data = Input::all();
        $order_id = $data['order_id'];




        $cmd = new EstimateOrderAction();

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

            $cmd = new StockMaterialAction();

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

        
        
        $cmd = new ApplySkillAction();

        $cmd->applySkill($order_id, $this->user_id);



        return \Redirect::route('work_show_order_page', ['id' => $order_id]);
    }

    public function cancelSkill()
    {
        $data = Input::all();

        $order_id = $data['order_id'];

        
        $cmd = new CancelApplySkillAction();

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


        $cmd = new DeleteOrderAction();

        $cmd->deleteOrder($order_id);


        return \Redirect::route('work_orders_page');
    }

    public function generate()
    {
        $cmd = new GenerateOrderAction();

        $cmd->generateOrder($this->user_id);


        return \Redirect::route('work_orders_page');
    }
}
