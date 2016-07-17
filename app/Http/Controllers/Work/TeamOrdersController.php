<?php

namespace App\Http\Controllers\Work;

use App\Commands\Work\TeamOrder\AcceptTeamOrderCommand;
use App\Commands\Work\TeamOrder\DeleteTeamOrderCommand;
use App\Exceptions\NotTeamLeaderException;
use App\Exceptions\WorkerWithoutTeamException;
use App\Repositories\Work\Team\TeamOrderRepository;
use App\Repositories\Work\Team\TeamOrderRepositoryObj;
use App\Repositories\Work\TeamOrdersRepository;
use App\Repositories\Work\WorkerRepositoryObj;
use App\Security\TeamOrderSecurity;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TeamOrdersController extends WorkController
{
    /** @var TeamOrderSecurity  */
    private $teamOrderSecurity;

    /** @var TeamOrdersRepository */
    protected $teamOrdersRepo;


    public function __construct(WorkerRepositoryObj $workerRepo, TeamOrdersRepository $teamOrdersRepo)
    {
        parent::__construct($workerRepo);

        $this->teamOrdersRepo = $teamOrdersRepo;

        $this->teamOrderSecurity = new TeamOrderSecurity($this->worker);
    }

    public function index()
    {
        try {

            $this->teamOrderSecurity->verifyViewTeamOrderList();
            
        }
        catch (WorkerWithoutTeamException $e)
        {
            Session::flash('message', 'Worker without team cannot view team-order list');
            return \Redirect::back();
        }

        $freeOrders = $this->teamOrdersRepo->getFreeTeamOrders();

        $workerTeamOrders = $this->teamOrdersRepo->getTeamOrdersByTeamId($this->worker->team_id);

        return $this->view('work.teamorder.orders_index', [
            'orders' => $freeOrders,
            'workerTeamOrders' => $workerTeamOrders,
        ]);
    }


}
