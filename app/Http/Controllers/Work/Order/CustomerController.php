<?php

namespace App\Http\Controllers\Work\Order;

use App\Commands\Work\IndividualOrder\CreateBuildOrderCommand;
use App\Http\Controllers\Controller;
use App\Jobs\SendMessageToWorker;
use App\Repositories\Work\OrderRepositoryObj;
use Illuminate\Support\Facades\Input;

class CustomerController extends Controller
{
    public function index()
    {
        // список заказов, с переходом на страницу и выводом полного состояния
    }

    public function createBuildOrder()
    {
        $data = Input::all();

//        $this->dispatch(new SendMessageToWorker(\Auth::id()));

        $customer_id = $this->user_id;
        $reward = 400;
        $type = 'gates';

        $cmd = new CreateBuildOrderCommand(new OrderRepositoryObj());

        $cmd->createBuildOrder($customer_id, $type, $reward);



        return \Redirect::route('work_orders_page');
    }
}
