<?php

namespace App\Modules\Work\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Work\Worker;
use App\Repositories\Work\WorkerRepositoryObj;
use Illuminate\Support\Facades\Session;

class WorkController extends Controller
{
    /** @var WorkerRepositoryObj */
    protected $workerRepo;
    
    /** @var  Worker */
    protected $worker;

    public function __construct()
    {
        parent::__construct();

//        $this->workerRepo = $workerRep;

/*        try {
            $this->worker = $this->workerRepo->findSimpleById($this->user_id);
        }
        catch (\Exception $e) {


            Session::flash('message', 'You are not worker');
            return \Redirect::route('profile_page');
        }
        */
    }

    // replace on view-composer
    protected function view($view = null, $data = [])
    {
        $data['user_id'] = $this->user_id;

        return parent::view($view, $data);
    }

}
