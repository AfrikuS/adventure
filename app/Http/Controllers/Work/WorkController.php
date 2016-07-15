<?php

namespace App\Http\Controllers\Work;

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

    public function __construct(WorkerRepositoryObj $workerRep)
    {
        parent::__construct();

        $this->workerRepo = $workerRep;

        try {
            $this->worker = $this->workerRepo->findSimpleById($this->user_id);
        }
        catch (\Exception $e) {
            
            Session::flash('message', 'You are not worker');
            return \Redirect::back();
        }
        
    }
    
    protected function view($view = null, $data = [])
    {
        $data['worker'] = (object) $this->worker->toArray();

        return parent::view($view, $data);
    }

}
