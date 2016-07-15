<?php

namespace App\Http\Controllers\Work;

use App\Commands\Work\TeamOrder\AcceptTeamOrderCommand;
use App\Commands\Work\TeamOrder\DeleteTeamOrderCommand;
use App\Exceptions\NotTeamLeaderException;
use App\Exceptions\WorkerWithoutTeamException;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Security\TeamOrderSecurity;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TeamOrdersController extends WorkController
{

    /** @var TeamOrderSecurity  */
    private $teamOrderSecurity;

    public function __construct(WorkerRepositoryObj $workerRepo)
    {
        parent::__construct($workerRepo);


        $this->teamOrderSecurity = new TeamOrderSecurity($this->worker);
    }

    public function index()
    {
//        $worker_id = \Auth::id();

        try {
            $this->teamOrderSecurity->verifyViewTeamOrderList();
        }
        catch (WorkerWithoutTeamException $e)
        {
            Session::flash('message', 'Worker without team cannot view team-order list');
            return \Redirect::back();
        }
//        catch (NotTeamLeaderException $e)
//        {
//            Session::flash('message', 'Only Team-Leader can accept team-order');
//            return \Redirect::back();
//        }
//        catch () {
//
//        }

        $orders = Order::
        select('id', 'desc', 'kind_work_title', 'price', 'acceptor_worker_id', 'acceptor_team_id', 'status', 'type')
            ->where('type', 'team')
            ->whereAnd('status', 'free')
            ->get();

//        $worker = $this->workerRep->findWithTeamById($worker_id);

        $userTeamOrders = $this->worker->team->orders; // TeamOrderRepository::getTeamOrders($worker->team);

        return $this->view('work.teamorder.orders_index', [
            'orders' => $orders,
            'userTeamOrders' => $userTeamOrders,
        ]);
    }

    public function acceptOrder()
    {
        $data = Input::all();
        $order_id = $data['order_id'];
        $user_id = \Auth::id();


        try {
            $cmd = new AcceptTeamOrderCommand($this->teamOrdersRep, $this->workerRepo);

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

        return \Redirect::route('work_show_teamorder_page', ['id' => $order_id]);
    }

    public function delete($id)
    {
        $cmd = new DeleteTeamOrderCommand($this->teamOrdersRep);

        $cmd->deleteTeamOrder($id);

        return redirect()->route('work_teamorders_page');
    }

}
